<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SightResource\Pages;
use App\Filament\Resources\SightResource\RelationManagers;
use App\Models\Sight;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class SightResource extends Resource
{
    protected static ?string $model = Sight::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\Section::make(__('Sight Details'))
                            ->schema([
                                // Title
                                Forms\Components\TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required()
                                    ->unique(Sight::class, 'title', ignoreRecord: true)
                                    ->lazy()
                                    ->afterStateUpdated(fn(callable $set, string $state) => $set('slug', Str::slug($state))),

                                // Slug
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(Sight::class, 'slug', ignoreRecord: true)
                                    ->disabled()
                                    ->prefixAction(function (?Sight $record) {
                                        if ($record) {
                                            return Forms\Components\Actions\Action::make('visit')
                                                ->icon('heroicon-s-external-link')
                                                ->url(route('sights.show', [
                                                    'sight' => $record,
                                                ]), shouldOpenInNewTab: true);
                                        }

                                        return null;
                                    }),

                                // Description
                                Forms\Components\Textarea::make('description')
                                    ->required(),

                                // Is Visible
                                Forms\Components\Toggle::make('is_visible')
                                    ->helperText(__('Whether this sight is visible'))
                                    ->required()
                                    ->default(true),

                                // Category
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),

                        // Marker Options
                        Forms\Components\Section::make(__('Marker Options'))
                            ->columns()
                            ->schema([
                                // Emit Events
                                Forms\Components\Toggle::make('emit_events')
                                    ->label(__('Emit Events'))
                                    ->helperText(__('Emits markerFound and markerLost events'))
                                    ->default(false),

                                // Smooth
                                Forms\Components\Toggle::make('smooth')
                                    ->helperText(__('Turn on/off camera smoothing'))
                                    ->reactive()
                                    ->default(false),

                                // Smooth Count
                                Forms\Components\TextInput::make('smooth_count')
                                    ->helperText(__('Number of matrices to smooth tracking over, more is smoother but slower follow'))
                                    ->required(fn(callable $get): bool => $get('smooth'))
                                    ->visible(fn(callable $get): bool => $get('smooth'))
                                    ->default(5),

                                // Smooth Tolerance
                                Forms\Components\TextInput::make('smooth_tolerance')
                                    ->helperText(__('Distance tolerance for smoothing, if smoothThreshold # of matrices are under tolerance, tracking will stay still'))
                                    ->required(fn(callable $get): bool => $get('smooth'))
                                    ->visible(fn(callable $get): bool => $get('smooth'))
                                    ->numeric()
                                    ->default(0.01),

                                // Smooth Threshold
                                Forms\Components\TextInput::make('smooth_threshold')
                                    ->helperText(__('Threshold for smoothing, will keep still unless enough matrices are over tolerance'))
                                    ->required(fn(callable $get): bool => $get('smooth'))
                                    ->visible(fn(callable $get): bool => $get('smooth'))
                                    ->numeric()
                                    ->default(2),
                            ]),

                        // Model Options
                        Forms\Components\Section::make(__('Model Options'))
                            ->schema([
                                // GLTF Model
                                Forms\Components\FileUpload::make('gltf_model')
                                    ->label(__('GLTF Model'))
                                    ->required()
                                    ->helperText(__('The .gltf file that will be displayed on the marker'))
                                    ->directory('sights/gltf-models')
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                        $file_name = $file->getClientOriginalName();
                                        $file_extension = explode('.', $file_name);

                                        return md5($file_name . time()) . '.' . end($file_extension);
                                    }),

                                // Position
                                Forms\Components\Fieldset::make(__('Position'))
                                    ->columns(3)
                                    ->schema([
                                        // Position X
                                        Forms\Components\TextInput::make('position.x')
                                            ->label(__('Position X'))
                                            ->required()
                                            ->numeric()
                                            ->default(0),

                                        // Position Y
                                        Forms\Components\TextInput::make('position.y')
                                            ->label(__('Position X'))
                                            ->required()
                                            ->numeric()
                                            ->default(0),

                                        // Position Z
                                        Forms\Components\TextInput::make('position.z')
                                            ->label(__('Position X'))
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                // Rotation
                                Forms\Components\Fieldset::make(__('Rotation'))
                                    ->columns(3)
                                    ->schema([
                                        // Rotation X
                                        Forms\Components\TextInput::make('rotation.x')
                                            ->label(__('Rotation X'))
                                            ->required()
                                            ->numeric()
                                            ->default(0),

                                        // Rotation Y
                                        Forms\Components\TextInput::make('rotation.y')
                                            ->label(__('Rotation Y'))
                                            ->required()
                                            ->numeric()
                                            ->default(0),

                                        // Rotation Z
                                        Forms\Components\TextInput::make('rotation.z')
                                            ->label(__('Rotation Z'))
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                // Scale
                                Forms\Components\Fieldset::make(__('Scale'))
                                    ->columns(3)
                                    ->schema([
                                        // Scale X
                                        Forms\Components\TextInput::make('scale.x')
                                            ->label(__('Scale X'))
                                            ->required()
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(0)
                                            ->rules(['min:0']),

                                        // Scale Y
                                        Forms\Components\TextInput::make('scale.y')
                                            ->label(__('Scale X'))
                                            ->required()
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(0)
                                            ->rules(['min:0']),

                                        // Scale Z
                                        Forms\Components\TextInput::make('scale.z')
                                            ->label(__('Scale X'))
                                            ->required()
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(0)
                                            ->rules(['min:0']),
                                    ]),
                            ]),
                    ]),


                Forms\Components\Group::make()
                    ->columnSpan(1)
                    ->schema([
                        // QR Code
                        Forms\Components\Card::make()
                            ->hidden(fn($record): bool => !$record)
                            ->schema([
                                // QR Code
                                Forms\Components\View::make('sights.qr-code'),
                            ]),

                        // Image
                        Forms\Components\Section::make(__('Image'))
                            ->schema([
                                // Image
                                Forms\Components\FileUpload::make('image')
                                    ->required()
                                    ->image()
                                    ->directory('sights/images'),
                            ]),

                        // Marker
                        Forms\Components\Section::make(__('Marker'))
                            ->schema([
                                // Marker Image
                                Forms\Components\FileUpload::make('marker_image')
                                    ->helperText(__('The marker image generated along with the marker pattern'))
                                    ->required()
                                    ->image()
                                    ->directory('sights/marker-images'),

                                // Marker Pattern
                                Forms\Components\FileUpload::make('marker_pattern')
                                    ->helperText(__('The marker pattern file ending in .patt'))
                                    ->required()
                                    ->directory('sights/marker-patterns')
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                        $file_name = $file->getClientOriginalName();
                                        $file_extension = explode('.', $file_name);

                                        return md5($file_name . time()) . '.' . end($file_extension);
                                    }),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index'  => Pages\ListSights::route('/'),
            'create' => Pages\CreateSight::route('/create'),
            'edit'   => Pages\EditSight::route('/{record}/edit'),
        ];
    }
}
