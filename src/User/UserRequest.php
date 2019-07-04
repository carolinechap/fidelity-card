<?php


namespace App\User;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class UserRequest
 * @package App\User
 */
class UserRequest
{


    private $roles = [];

    /**
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(message="L'email n'est pas valide")
     */
    private $email;

    /**
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     * @Assert\Length(min="6", minMessage="Le mot de passe doit faire au moins {{ limit }} caractères")
     */
    private $plainPassword;

    /**
     * @Assert\Length(max="6", maxMessage="Le numéro de rue ne doit pas dépasser {{ limit }} caractères")
     */
    private $numberStreet;

    /**
     * @Assert\Length(max="150", maxMessage="Le nom de la rue ne doit pas dépasser {{ limit }} caractères")
     */
    private $nameStreet;

    /**
     * @Assert\Length(max="20", maxMessage="Le code postal ne doit pas dépasser {{ limit }} caractères")
     */
    private $zipCode;

    /**
     * @Assert\Length(max="100", maxMessage="La ville ne doit pas dépasser {{ limit }} caractères")
     */
    private $city;

    /**
     * @Assert\Length(max="100", maxMessage="Le pays ne doit pas dépasser {{ limit }} caractères")
     */
    private $country;

    /**
     */
    private $customerCode;

    /**
     * @Assert\Length(max="100", maxMessage="Le prénom ne doit pas dépasser {{ limit }} caractères")
     */
    private $lastname;

    /**
     * @Assert\Length(max="100", maxMessage="Le nom ne doit pas dépasser {{ limit }} caractères")
     */
    private $firstname;

public function __construct(string $role = 'ROLE_USER')
{
    $this->roles[] = $role;
}


    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return UserRequest
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return UserRequest
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param  $plainPassword
     * @return UserRequest
     */
    public function setPlainPassword( $plainPassword): UserRequest
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberStreet()
    {
        return $this->numberStreet;
    }

    /**
     * @param mixed $numberStreet
     * @return UserRequest
     */
    public function setNumberStreet($numberStreet)
    {
        $this->numberStreet = $numberStreet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNameStreet()
    {
        return $this->nameStreet;
    }

    /**
     * @param mixed $nameStreet
     * @return UserRequest
     */
    public function setNameStreet($nameStreet)
    {
        $this->nameStreet = $nameStreet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     * @return UserRequest
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return UserRequest
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return UserRequest
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * @param mixed $customerCode
     * @return UserRequest
     */
    public function setCustomerCode($customerCode)
    {
        $this->customerCode = $customerCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     * @return UserRequest
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     * @return UserRequest
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }






}