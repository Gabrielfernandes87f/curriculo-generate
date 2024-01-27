<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Certification;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\CurriculoController;


use App\Filament\Resources\CertificationResource\Pages;
use App\Filament\Resources\CertificationResource\RelationManagers;

class CertificationResource extends Resource
{
    protected static ?string $model = Certification::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Currículo';

    protected static ?string $pluralModelLabel = 'Currículo';

    protected static ?string $slug = 'curriculo';


    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
    
        
        $firstUser = User::orderBy('id')->first();
    
        if ($user->id === $firstUser->id) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('user_id', $user->id);
        }
    }
    
    


  public static function form(Form $form): Form
    {
        $user = auth()->user()->id;


        return $form
        ->schema([

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->options(User::all()->pluck('id', 'name')->where('id', $user))
                ->live()
                ->searchable()
                ->preload()
                ->default($user)
                ->label('Nome do Usuário')
                ->required()
                ->columnSpanFull(),

            Section::make('Cabeçalho')
                ->description('Infomações basica')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required(),
                    Forms\Components\TextInput::make('website')
                        ->label('Site')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact')
                        ->label('Contato'),
                    Forms\Components\TextInput::make('location')
                        ->label('Endereço')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('linkedin')
                        ->label('LinkedIn'),
            ]) 
            ->columns(3),

            Section::make('')
                ->description('')
                ->schema([
                    Forms\Components\Textarea::make('expertise')
                        ->label('Expertise')
                        ->rows(1)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('about')
                        ->label('Sobre')
                        ->columnSpanFull()
                        ->rows(5),
                    Forms\Components\Textarea::make('education')
                        ->label('Educação')
                        ->columnSpanFull()
                        ->rows(1)
                        ->maxLength(150),
                                
                    Forms\Components\Textarea::make('course')
                        ->label('Cursos')
                        ->rows(4)
                        ->columnSpanFull(),      

                    Forms\Components\TextInput::make('course_link')
                        ->label('Link do curso')
                        ->columnSpanFull()
                        ->maxLength(150),
                
                    Forms\Components\TextInput::make('languages')
                        ->label('Idiomas')
                        ->maxLength(80),
            
                    Forms\Components\TextInput::make('Skills')
                        ->label('Skills')
                        ->columnSpanFull(),  
                                
                    Forms\Components\TextInput::make('projects_link')
                        ->label('Link do projeto')
                        ->maxLength(255)->columnSpanFull(),
                ])
                ->collapsible()
                ->persistCollapsed()
                ->columns(2),    
    

            Repeater::make('professional')
                ->label('Experiência')
                ->relationship('professional')
                ->schema([
                    Forms\Components\TextInput::make('company')
                        ->label('Empresa')
                        ->required(),
                    Forms\Components\TextInput::make('period')
                        ->label('Período'),
                    Forms\Components\TextInput::make('function')
                        ->label('Cargo'),
                    Forms\Components\Textarea::make('description')
                        ->label('Descrição')
                        ->required()
                        ->rows(10)
                        ->columnSpanFull(),  
                    Forms\Components\TextInput::make('technology')
                        ->label('Tecnologias'),
                ])
                ->collapsible()
                ->persistCollapsed()
                ->columnSpanFull(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->url(fn (Certification $record) => asset('download-pdf/' . $record->id), shouldOpenInNewTab: true)
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('linkedin')
                    ->label('LinkedIn')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('website')
                    ->label('Site')
                    ->url(fn ($record) => $record->website, shouldOpenInNewTab: true)
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('baixar Currículo')
                ->url(fn (Certification $record) => asset('download-pdf/' . $record->id), shouldOpenInNewTab: true),
                /*  ->url('download-pdf/{id}', shouldOpenInNewTab: true), */
            ], position: ActionsPosition::BeforeCells)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),

                   # BulkAction::make('baixar Currículo')
                   /*  ->action(fn (Collection $records) => redirect()->route('download-pdf')), */
                   # ->url('download-pdf', shouldOpenInNewTab: true),
                
                
                ]),
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
            'index' => Pages\ListCertifications::route('/'),
            'create' => Pages\CreateCertification::route('/create'),
            'edit' => Pages\EditCertification::route('/{record}/edit'),
        ];
    }
}
