<?php

class Contact extends BaseContact
{
    public function getHomeAddress()
    {
        if (count($this->collContactAddresss))
        {
            foreach($this->collContactAddresss as $ca)
            {
                if ($ca->getType()===ContactPeer::HOME) return $ca;
            }
        }
        return $this->getAddressByType(ContactPeer::HOME); 
    }

    public function getWorkAddress()
    {
        if (count($this->collContactAddresss))
        {
            foreach($this->collContactAddresss as $ca)
            {
                if ($ca->getType()===ContactPeer::WORK) return $ca;
            }
        }
        return $this->getAddressByType(ContactPeer::WORK); 
    }

    public function setHomeAddress($a)
    {
        $a->setType(ContactPeer::HOME);
        $a->setContact($this);
    }

    public function setWorkAddress($a)
    {
        $a->setType(ContactPeer::WORK);
        $a->setContact($this);
    }

    public function getHomePhone()
    {
        if (count($this->collContactPhones))
        {
            foreach($this->collContactPhones as $cp)
            {
                if ($cp->getType()===ContactPeer::HOME) return $cp;
            }
        }
        return $this->getPhoneByType(ContactPeer::HOME);
    }

    public function getWorkPhone()
    {
        if (count($this->collContactPhones))
        {
            foreach($this->collContactPhones as $cp)
            {
                if ($cp->getType()===ContactPeer::WORK) return $cp;
            }
        }
        return $this->getPhoneByType(ContactPeer::WORK);
    }
    
    public function getMobilePhone()
    {
        if (count($this->collContactPhones))
        {
            foreach($this->collContactPhones as $cp)
            {
                if ($cp->getType()===ContactPeer::MOBILE) return $cp;
            }
        }
        return $this->getPhoneByType(ContactPeer::MOBILE);
    }
    
    public function setHomePhone($a)
    {
        $a->setType(ContactPeer::HOME);
        $a->setContact($this);
    }
    
    public function setWorkPhone($a)
    {
        $a->setType(ContactPeer::WORK);
        $a->setContact($this);
    }
    
    public function setMobilePhone($a)
    {
        $a->setType(ContactPeer::MOBILE);
        $a->setContact($this);
    }
    
    public function getAddressByType($type)
    {
        $c = new Criteria();
        $c->add(ContactAddressPeer::TYPE, $type);
        $addresses = $this->getContactAddresss($c);
        if (count($addresses))
            return $addresses[0];
        else
            return null; 
    }

    public function getPhoneByType($type)
    {
        $c = new Criteria();
        $c->add(ContactPhonePeer::TYPE, $type);
        $c->addDescendingOrderByColumn(ContactPhonePeer::PREFERRED);
        $phones = $this->getContactPhones($c);
        if (count($phones))
            return $phones[0];
        else
            return null; 
    }
    
    public function addPhoneNumber($phone_number, $type_id)
    {
        $pn = new ContactPhone();
        $pn->setType($type_id);
        $pn->setPhone($phone_number);
        $this->addContactPhone($pn);
        $pn->save();
    }
    
    public function addWorkPhone($phone_number)
    {
        $this->addPhoneNumber($phone_number, ContactPeer::WORK);
    }
    
    public function addHomePhone($phone_number)
    {
        $this->addPhoneNumber($phone_number, ContactPeer::HOME);
    }
    
}
