<?php
    namespace App\Http\Traits;
    use App\Models\Images;

    trait ArtistTrait {
        
        public function getAllImages($userid) {
            // Fetch all images
            $images = Images::where('user_id',$userid)->get();
            return $images;
        }
    }