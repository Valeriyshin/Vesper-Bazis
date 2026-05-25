<?php

namespace App\Filament\Resources\FamilyClubs;

use App\Filament\Resources\FamilyClubs\Pages\ManageFamilyClubs;
use App\Models\FamilyClub;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FamilyClubResource extends Resource
{
    protected static ?string $model = FamilyClub::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static ?string $navigationLabel = 'Family Club';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->visibility('public')
                    ->image()
                    ->disk('public')
                    ->directory('fc')
                    ->hint('Рекомендуется 904x646')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('text_ru')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('text_kk')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('weight')
            ->defaultSort('weight')
            ->columns([
                TextColumn::make('text')
                    ->label('Текст')
                    ->formatStateUsing(function($state) {
                        if ($state === null) {
                            return '';
                        }

                        $text = str_replace(["\r\n", "\r"], "\n", (string)$state);
                        $firstLine = Str::of($text)->before("\n")->toString();

                        $limited = Str::limit($firstLine, 50, '…');

                        $wasMultiline = str_contains($text, "\n");
                        $truncatedByLength = (mb_strlen($firstLine, 'UTF-8') > 50);

                        if ($wasMultiline && !$truncatedByLength && !Str::endsWith($limited, '…')) {
                            $limited .= '…';
                        }

                        return $limited;
                    })
                    ->tooltip(fn($state) => $state)
                    ->wrap(false),
                ImageColumn::make('image')
                    ->checkFileExistence(false),
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
            'index' => ManageFamilyClubs::route('/'),
        ];
    }
}
