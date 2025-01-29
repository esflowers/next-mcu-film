<?php
    declare(strict_types=1);

    class NextMovie{
        private int $days_until;
        private string $title, $following_production, $release_date, $poster_url, $overview, $type;

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
                $days === 0 => 'It opens today!!',
                $days == 1  => 'Tomorrow is the premiere!',
                $days < 7   => 'It premieres this week',
                $days < 30  => "It opens this month, in $days days",
                default     => "Releases in $days days",
            };
        }

        public static function fetch_and_create_movie(string $api_url) : NextMovie{
            $result = file_get_contents($api_url);
            $data = json_decode($result, true);

            return new self(
                $data["days_until"],
                $data["title"],
                $data["following_production"]["title"] ?? "Desconocido",
                $data["release_date"],
                $data["poster_url"],
                $data["overview"],
                $data["type"]
            );
        }

        public function get_data(){
            return get_object_vars($this);
        }
    }
?>