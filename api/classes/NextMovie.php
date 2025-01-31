<?php
    declare(strict_types=1);

    class NextMovie{
        private int $days_until;
        private string $title, $release_date, $poster_url, $overview, $type;
        private array $following_production;

        public function __construct($days_until, $title, $following_production, $release_date, $poster_url, $overview, $type)
        {
            $this->days_until = $days_until;
            $this->title = $title;
            $this->following_production = $following_production;
            $this->release_date = $release_date;
            $this->poster_url = $poster_url;
            $this->overview = $overview;
            $this->type = $type;
        }

        public function get_until_messages() : string{
            $days = $this->days_until;
            return match(true){
                $days === -1 => "Unknown",
                $days === 0 => 'It opens today!!',
                $days == 1  => 'Tomorrow is the premiere!',
                $days < 7   => 'It premieres this week',
                $days < 30  => "It opens this month, in $days days",
                default     => "Releases in $days days",
            };
        }

        public static function fetch_and_create_movie(string $api_url, ?string $date = null) : NextMovie{
            $url = $date ? "$api_url?date=$date" : $api_url;
            $result = file_get_contents($url);
            $data = json_decode($result, true);

            if (!$data || !isset($data["title"])) {
                return new self(
                    -1,
                    "Unknown",
                    [],
                    "Unknown",
                    "./img/unknown.jpg",
                    "No overview available.",
                    "Unknown"
                );
            }

            return new self(
                $data["days_until"] ?? 0,
                $data["title"] ?? "Unknown",
                $data["following_production"] ?? [],
                $data["release_date"] ?? "Unknown",
                $data["poster_url"] ?? "",
                $data["overview"] ?? "No overview available",
                $data["type"] ?? "Unknown"
            );
        }

        public function get_data(){
            return get_object_vars($this);
        }

        public function get_following_production(int $steps = 1): array {
            $next = $this->following_production;

            for ($i = 1; $i < $steps; $i++) {
                if (!isset($next["following_production"]) || empty($next["following_production"])) {
                    return $next;
                }
                $next = $next["following_production"];
            }

            return $next;
        }
    }
?>