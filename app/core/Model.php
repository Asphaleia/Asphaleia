<?php
class Model
{
    public function cutDescription($description)
    {
        $maxChars = $this->database->get_config("max_description_chars");
        if( strlen($description) > $maxChars) {
            $description = substr($description, 0, $maxChars)." ...";
        }
        return $description;
    }
}
?>