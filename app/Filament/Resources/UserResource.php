<?php

namespace App\Filament\Resources;

use Filament\Tables\Columns\TextColumn;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Form as FormsForm;
use Filament\Tables\Table as TablesTable;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $pluralModelLabel = 'Users';
    protected static ?string $modelLabel = 'User';
    protected static ?int $navigationSort = 1;

    public static function form(FormsForm $form): FormsForm
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'customer' => 'Customer',
                    ])
                    ->required(),

                Forms\Components\DatePicker::make('date_of_birth')
                    ->label('Date of Birth')
                    ->nullable(),

                Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->nullable(),

                Forms\Components\Textarea::make('address')
                    ->rows(3)
                    ->nullable(),

                Forms\Components\TextInput::make('city')
                    ->maxLength(100)
                    ->nullable(),

                Forms\Components\TextInput::make('contact_no')
                    ->label('Contact Number')
                    ->tel()
                    ->maxLength(20)
                    ->nullable(),

                Forms\Components\TextInput::make('paypal_id')
                    ->label('PayPal ID')
                    ->email()
                    ->maxLength(255)
                    ->nullable(),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create'),
            ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn(?string $state): string => $state === 'admin' ? 'success' : 'primary'),
                Tables\Columns\TextColumn::make('gender')->sortable(),
                Tables\Columns\TextColumn::make('city')->sortable(),
                Tables\Columns\TextColumn::make('contact_no')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('paypal_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
