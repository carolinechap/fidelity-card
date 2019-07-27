<?php


namespace App\User;

use App\Validator\Constraints\IsUniqueUser;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class UserRequest
 * @package App\User
 */
class UserRequest
{


    /**
     * @var array
     */
    private $roles = [];

    /**
     * @Assert\NotBlank(message="user.email.blank")
     * @Assert\Email(message="user.email.message")
     * @IsUniqueUser()
     */
    private $email;

    /**
     * @var $password
     */
    private $password;

    /**
     * @Assert\NotBlank(message="user.password.blank")
     * @Assert\Length(min="6", minMessage="user.password.min", max="255", maxMessage="user.password.max")
     */
    private $plainPassword;

    /**
     * @Assert\Positive(message="user.street_number.positive")
     */
    private $numberStreet;

    /**
     * @Assert\Length(max="150", maxMessage="user.street_name.max")
     */
    private $nameStreet;

    /**
     * @Assert\Length(max="20", maxMessage="user.zip_code.max")
     */
    private $zipCode;

    /**
     * @Assert\Length(max="100", maxMessage="user.city.max")
     */
    private $city;

    /**
     * @Assert\Length(max="100", maxMessage="user.country.max")
     */
    private $country;

    /**
     */
    private $customerCode;

    /**
     * @Assert\Length(max="100", maxMessage="user.lastname.max")
     */
    private $lastname;

    /**
     * @Assert\Length(max="100", maxMessage="user.fistname.max")
     */
    private $firstname;

    /**
     * UserRequest constructor.
     * @param string $role
     */
public function __construct(string $role = 'ROLE_USER')
{
    $this->roles[] = $role;
}


    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param $roles
     * @return $this
     */
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