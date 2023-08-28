<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                ->required()
                ->native(false),
                TimePicker::make('start')
                ->required()
                ->seconds(false)
                ->displayFormat('h:i A'),
                TimePicker::make('end')
                ->seconds(false)
                ->displayFormat('h:i A'),
                Select::make('pet_id')
                -> relationship('pet', 'name')
                -> native(false)
                -> searchable()
                -> preload()
                -> required(),
                TextInput::make('description')
                ->required(),
                Select::make('status')
                -> native(false)
                -> options(AppointmentStatus::class)
                -> visibleOn(Pages\EditAppointment::class)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pet.name')
                ->searchable()
                ->sortable(),
                TextColumn::make('description'),
                TextColumn::make('date')
                ->date('d/m/Y')
                ->searchable()
                ->sortable(),
                TextColumn::make('start')
                -> time('h:i')
                -> label('Entrada')
                -> sortable(),
                TextColumn::make('end')
                -> time('h:i')
                -> label('Salida')
                -> sortable(),
                TextColumn::make('status')
                -> sortable()
                -> badge(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Confirmed')
                    -> action(function(Appointment $record){
                        $record->status = AppointmentStatus::Confirmed;
                        $record->save();
                    })
                    -> visible(fn (Appointment $record) => $record->status === AppointmentStatus::Created)
                    -> color('success')
                    -> icon('heroicon-o-check'),
                Tables\Actions\Action::make('Cancel')
                    -> action(function(Appointment $record){
                        $record->status = AppointmentStatus::Cancelled;
                        $record->save();
                    })
                    -> visible(fn (Appointment $record) => $record->status != AppointmentStatus::Cancelled)
                    -> color('danger')
                    -> icon('heroicon-o-x-mark'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }    
}
