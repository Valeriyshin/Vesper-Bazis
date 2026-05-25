<?php

namespace App\Filament\Resources\TemplateStrings;

use App\Filament\Resources\TemplateStrings\Pages\ManageTemplateStrings;
use App\Models\TemplateString;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TemplateStringResource extends Resource
{
    protected static ?string $model = TemplateString::class;

    protected static ?string $navigationLabel = 'Строки и тексты';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('warning')
                    ->state('⚠️ **Не меняйте поля module и key без явной необходимости.**')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->markdown(),
                TextInput::make('module')
                    ->required()
                    ->hint('Крайне рекомендуется нижний регистр'),
                TextInput::make('key')
                    ->required()
                    ->hint('Крайне рекомендуется нижний регистр'),
                Textarea::make('value_ru')
                    ->hint(fn($record) => $record?->hint)
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('value_kk')
                    ->hint(fn($record) => $record?->hint)
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('comment')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('key')
            ->columns([
                TextColumn::make('module')
                    ->sortable()
                    ->searchable()
                    ->visible(
                        fn(ManageTemplateStrings $livewire) => $livewire->activeTab === null
                                                               || $livewire->activeTab
                                                                  === 'All'
                    ),
                TextColumn::make('key')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('value_ru')
                    ->label('Value (ru)')
                    ->searchable()
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
                TextColumn::make('value_kk')
                    ->label('Value (kz)')
                    ->searchable()
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
                    ->wrap(false)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('comment')
                    ->searchable(),
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
            'index' => ManageTemplateStrings::route('/'),
        ];
    }
}
