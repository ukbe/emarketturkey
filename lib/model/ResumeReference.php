<?php

class ResumeReference extends BaseResumeReference
{
    public function getEmail()
    {
        $contact = $this->getContact();
        return $contact ? $contact->getEmail() : null;
    }
    
    public function getPhoneNumber()
    {
        $contact = $this->getContact();
        return $contact ? $contact->getWorkPhone() : null;
    }
    
    public function setEmail($email)
    {
        $contact = $this->getContact();
        if (!$contact)
        {
            $contact = new Contact();
            $contact->setEmail($email);
            $contact->save();
            $this->setUserContactId($contact->getId());
            $this->save();
        }
        else
        {
            $contact->setEmail($email);
            if ($contact->isModified()) $contact->save();
        }
    }

    public function setPhoneNumber($phone_number)
    {
        $contact = $this->getContact();
        if (!$contact)
        {
            $contact = new Contact();
            $contact->save();
        }
        $wp = $contact->getWorkPhone();
        if (!$wp)
        {
            $contact->addWorkPhone($phone_number);
            $wp = $contact->getWorkPhone();
        }
        else
        {
            $wp->setPhone($phone_number);
            $wp->save();
        }
    }
}
