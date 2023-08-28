<?php

namespace App\Filament\Resources;

use App\Enums\PetType;
use App\Filament\Resources\PetResource\Pages;
use App\Filament\Resources\PetResource\RelationManagers;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required(),
                DatePicker::make('date_birth')
                ->native(false)
                ->displayFormat('d/m/Y'),
                Select::make('type')
                ->options(PetType::class)
                ->native(false),
                FileUpload::make('avatar')
                ->image()
                ->imageEditor(),
                Select::make('owner_id')
                -> relationship('owner', 'name')
                -> native(false)
                -> searchable()
                -> preload()
                -> createOptionForm([
                    TextInput::make('name')
                    ->required(),
                    TextInput::make('email')
                    ->email()
                    ->required(),
                    TextInput::make('phone')
                    ->tel()
                    ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                ->circular(),
                TextColumn::make('name')
                ->sortable()
                ->searchable(),
                TextColumn::make('type'),
                TextColumn::make('date_birth')
                ->sortable()
                ->searchable(),
                TextColumn::make('owner.name')
                ->searchable(),
                TextColumn::make('created_at')
                ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }    
}
