<?php

namespace App\Services;

class DiscordEmbedBuilder
{
    private array $embed = [];

    public static function make(): static
    {
        return new static();
    }

    public function title(string $title): static
    {
        $this->embed['title'] = $title;
        return $this;
    }

    public function description(string $description): static
    {
        $this->embed['description'] = $description;
        return $this;
    }

    public function color(int $color): static
    {
        $this->embed['color'] = $color;
        return $this;
    }

    public function field(string $name, string $value, bool $inline = false): static
    {
        $this->embed['fields'][] = [
            'name'   => $name,
            'value'  => $value,
            'inline' => $inline,
        ];
        return $this;
    }

    public function footer(string $text, ?string $iconUrl = null): static
    {
        $this->embed['footer'] = array_filter([
            'text'     => $text,
            'icon_url' => $iconUrl,
        ]);
        return $this;
    }

    public function thumbnail(string $url): static
    {
        $this->embed['thumbnail'] = ['url' => $url];
        return $this;
    }

    public function timestamp(?string $datetime = null): static
    {
        $this->embed['timestamp'] = $datetime ?? now()->toIso8601String();
        return $this;
    }

    public function build(): array
    {
        return $this->embed;
    }
}