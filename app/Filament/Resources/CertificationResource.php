<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Certification;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\CurriculoController;
use App\Filament\Resources\CertificationResource\Pages;
use App\Filament\Resources\CertificationResource\RelationManagers;

use Illuminate\Database\Eloquent\Builder;

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
            ->relationship('user', 'id')
            ->default($user)
            ->getOptionLabelFromRecordUsing(fn () => "{$user}")
            ->label('Usúario - nome')
            ->native(false)
            /* ->disabled()  */
            ->preload()
            ->required()
            ->columnSpanFull(),
            
            Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\TextInput::make('website')
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(255),
            Forms\Components\TextInput::make('contact'),
            Forms\Components\TextInput::make('location')
                ->maxLength(255),
            Forms\Components\TextInput::make('linkedin'),

            RichEditor::make('expertise')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),


            RichEditor::make('about')
            ->disableToolbarButtons([
                'attachFiles',
                'blockquote',
                'bold',
                'bulletList',
                'codeBlock',
                'h2',
                'h3',
                'italic',
                'link',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ]),

            Forms\Components\Textarea::make('education')
                    ->columnSpanFull()
                    ->maxLength(65535),
                    
            RichEditor::make('course')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->columnSpanFull(),      

            Forms\Components\TextInput::make('course_link')
                    ->maxLength(255),
    
            Forms\Components\TextInput::make('languages')
                    ->maxLength(255),

            Forms\Components\TextInput::make('Skills')
                    ->columnSpanFull(), 

           RichEditor::make('project')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->columnSpanFull(),   
                    
            Forms\Components\TextInput::make('projects_link')
                    ->maxLength(255)->columnSpanFull(), 



            Repeater::make('professional')
                ->relationship('professional')
                ->schema([
                    Forms\Components\TextInput::make('company')->required(),
                    Forms\Components\TextInput::make('period'),
                    Forms\Components\TextInput::make('function'),
                    RichEditor::make('description')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])->required()
                    ->columnSpanFull(),  
                    Forms\Components\TextInput::make('technology'),
                ])->columnSpanFull(),
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
                ->searchable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('email')
                ->toggleable(),
            Tables\Columns\TextColumn::make('location')
                ->toggleable(),
            Tables\Columns\TextColumn::make('website')
            ->url(fn ($record) => $record->website, shouldOpenInNewTab: true)
                ->toggleable(),
            Tables\Columns\TextColumn::make('projects_link')
                ->toggleable(),
            Tables\Columns\TextColumn::make('project')
                ->toggleable(),
            Tables\Columns\TextColumn::make('linkedin')
                ->toggleable(),
            Tables\Columns\TextColumn::make('about')
                ->toggleable(),
            Tables\Columns\TextColumn::make('education')
                ->toggleable(),
            Tables\Columns\TextColumn::make('course')
                ->toggleable(),
            Tables\Columns\TextColumn::make('course_link')
                ->toggleable(),
            Tables\Columns\TextColumn::make('expertise')
                ->toggleable(),
            Tables\Columns\TextColumn::make('languages')
                ->toggleable(),
            Tables\Columns\TextColumn::make('experience')
                ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('baixar Currículo')
                ->url(fn (Certification $record) => asset('download-pdf/' . $record->id), shouldOpenInNewTab: true),

                /*  ->url('download-pdf/{id}', shouldOpenInNewTab: true), */
            ])
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
