<?php

namespace App\Filament\Resources\ProgressStages;

use App\Filament\Resources\ProgressStages\Pages\ManageProgressStages;
use App\Models\ProgressStage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgressStageResource extends Resource
{
    protected static ?string $model = ProgressStage::class;

    protected static ?string $navigationLabel = 'Прогресс';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title_ru';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_ru')
                    ->required(),
                TextInput::make('title_kk')
                    ->required(),
                self::details('ru'),
                self::details('kk'),
                FileUpload::make('images')
                    ->columnSpanFull()
                    ->label('Изображения')
                    ->disk('public')
                    ->directory('progress')
                    ->image()
                    ->multiple()          // state = массив путей, как у тебя в БД
                    ->reorderable()       // сортировка drag&drop
                    ->appendFiles()       // чтобы новые добавлялись к списку, а не затирали
                    ->imageEditor()       // обрезка/поворот
                    ->imageCropAspectRatio('10:7')
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth(1000)
                    ->imageResizeTargetHeight(700),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_ru')
            ->reorderable('weight')
            ->defaultSort('weight')
            ->columns([
                TextColumn::make('title_ru')
                    ->label('Этап')
                    ->searchable(),
                TextColumn::make('weight')
                    ->label('Порядок')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProgressStages::route('/'),
        ];
    }

    private static function images(): Repeater
    {
        return Repeater::make('images')
            ->label('Изображения')
            ->schema([
                FileUpload::make('path')
                    ->label(false)
                    ->disk('public')
                    ->directory('progress')
                    ->image()
                    ->maxFiles(1)
                    ->reorderable(false) // сортировку делаем на уровне repeater
                    ->imageEditor()      // включаем UI обрезки
                                         // фиксируем пропорцию 641x654:
                    ->imageCropAspectRatio('641:654')
                    // сохраняем (и при желании подгоняем) под 2x:
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth(1282)
                    ->imageResizeTargetHeight(1308),
            ])
            ->defaultItems(0)
            ->addActionLabel('Добавить изображение')
            ->reorderable()
            ->columns(1)
            // ["a","b"] -> [["path"=>"a"],["path"=>"b"]]
            ->formatStateUsing(fn($state) => collect($state ?? [])
                ->map(fn($v) => ['path' => $v])
                ->all()
            )
            // [["path"=>"a"], ...] -> ["a", ...]
            ->dehydrateStateUsing(fn($state) => collect($state ?? [])
                ->pluck('path')
                ->filter(fn($v) => filled($v))
                ->values()
                ->all()
            );
    }

    private static function details(string $lang): Repeater
    {
        return Repeater::make('details_' . $lang)
            ->label("Детали ($lang)")
            ->columnSpanFull()
            ->schema([
                TextInput::make('value')
                    ->label(false)
                    ->required()
                    ->columnSpanFull(),
            ])
            ->defaultItems(0)
            ->addActionLabel('Добавить строку')
            ->reorderable()
            ->columns(1)
            // превращаем ["a","b"] <-> [["value"=>"a"],["value"=>"b"]]
            ->formatStateUsing(fn($state) => collect($state ?? [])
                ->map(fn($v) => ['value' => $v])
                ->all()
            )
            ->dehydrateStateUsing(fn($state) => collect($state ?? [])
                ->pluck('value')
                ->filter(fn($v) => filled($v))
                ->values()
                ->all()
            );
    }
}
