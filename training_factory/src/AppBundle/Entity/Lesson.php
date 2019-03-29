<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Lesson
 *
 * @ORM\Table(name="lesson")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LessonRepository")
 */
class Lesson
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="time", type="string", length=255)
     */
    private $time;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var int
     *
     * @ORM\Column(name="max_persons", type="integer")
     */
    private $maxPersons;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="lessons")
     * @ORM\JoinColumn(name="instructor_id", referencedColumnName="id")
     */
    private $instructor;


    /**
     * @ORM\ManyToOne(targetEntity="Training", inversedBy="lessons")
     * @ORM\JoinColumn(name="training_id", referencedColumnName="id")
     */
    private $training;

    /**
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="lesson")
     */
    private $registrations;

    public function __construct()
    {
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
     * Set time
     *
     * @param string $time
     *
     * @return Lesson
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Lesson
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Lesson
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set maxPersons
     *
     * @param integer $maxPersons
     *
     * @return Lesson
     */
    public function setMaxPersons($maxPersons)
    {
        $this->maxPersons = $maxPersons;

        return $this;
    }

    /**
     * Get maxPersons
     *
     * @return int
     */
    public function getMaxPersons()
    {
        return $this->maxPersons;
    }

    /**
     * @return mixed
     */
    public function getInstructor()
    {
        return $this->instructor;
    }

    /**
     * @param mixed $instructor
     */
    public function setInstructor($instructor)
    {
        $this->instructor = $instructor;
    }

    /**
     * @return mixed
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * @param mixed $training
     */
    public function setTraining($training)
    {
        $this->training = $training;
    }

    /**
     * @return mixed
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * @param mixed $registrations
     */
    public function setRegistrations($registrations)
    {
        $this->registrations = $registrations;
    }

}

