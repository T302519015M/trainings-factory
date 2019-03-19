<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login_name", type="string", length=20)
     */
    private $loginName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=65)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=25)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="prefix", type="string", length=10, nullable=true)
     */
    private $prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=35)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date")
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(name="rol", type="string", columnDefinition="enum('instructor', 'member')")
     */
    private $rol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hire_date", type="date")
     */
    private $hire_date;

    /**
     * @ORM\Column(name="salary", type="decimal", precision=7, scale=2)
     */
    private $salary;

    /**
     * @var string
     * @ORM\Column(name="street", type="string", length=50)
     */
    private $street;

    /**
     * @var string
     * @ORM\Column(name="postal_code",type="string", length=10)
     */
    private $postal_code;

    /**
     * @var string
     * @ORM\Column(name="place",type="string", length=35)
     */
    private $place;


    /**
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="instructor")
     */
    private $lessons;

    /**
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="member")
     */
    private $registrations;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set loginName
     *
     * @param string $loginName
     *
     * @return Person
     */
    public function setLoginName($loginName)
    {
        $this->loginName = $loginName;

        return $this;
    }

    /**
     * Get loginName
     *
     * @return string
     */
    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Person
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     *
     * @return Person
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Person
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Person
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set rol
     *
     * @param array $rol
     *
     * @return Person
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return array
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @return \DateTime
     */
    public function getHireDate()
    {
        return $this->hire_date;
    }

    /**
     * @param \DateTime $hire_date
     */
    public function setHireDate($hire_date)
    {
        $this->hire_date = $hire_date;
    }

    /**
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param float $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param string $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

}
