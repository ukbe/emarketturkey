<?php

class UserProfile extends BaseUserProfile
{
    public function getPictureUri($large=false)
    {
        // first check if user has a profile photo
        $photo = $this->getMediaItem();
        if ($photo)
        {
            if (!$large)
            {
                if (file_exists($photo->getThumbnailPath())) return $photo->getThumbnailUri();
                else return $this->getGender()===UserProfilePeer::GENDER_FEMALE ? "$path/no_photo_female_notfound.jpg" : "$path/no_photo_male_notfound.jpg";
            }
            else
            {
                if (file_exists($photo->getPath())) return $photo->getUri();
                else return $this->getGender()===UserProfilePeer::GENDER_FEMALE ? "$path/no_photo_female_notfound.jpg" : "$path/no_photo_male_notfound.jpg";
            }
        }

        // if not
        $users = $this->getUsers();
        $path = "content/user/profile";
        if (count($users))
            return $users[0]->getGender()===UserProfilePeer::GENDER_FEMALE ? "$path/no_photo_female.jpg" : "$path/no_photo_male.jpg";
        else
            return "$path/no_photo_male.jpg";
    }
    
}
