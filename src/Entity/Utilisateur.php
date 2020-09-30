<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;



/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields={"pseudo"}, message="Il existe deja un compte utilisateur avec ce pseudo ! ")
 * @UniqueEntity(fields={"email"}, message="Il existe deja un compte utilisateur avec cet email ! ")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "L'email {{ value }} n'est pas un email valide.",
     *     checkMX = true)
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     *
     */
    private $motDePasse;

    /**
     * @Assert\NotBlank(groups={"Registration"})
     * @RollerworksPassword\PasswordStrength(minLength=4, minStrength=4, message="Votre mot de passe doit contenir au minimum 6 caractères, 1 chiffre, 1 majuscule et 1 caractère spécial")
     */
    private $plainPassword; // propriété qui va stocker temporairement le mot de passe en clair saisi.

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="auteur", orphanRemoval=true)
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reponse", mappedBy="auteur", orphanRemoval=true)
     */
    private $reponses;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Avatar", inversedBy="utilisateur", cascade={"persist", "remove"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionLike", mappedBy="utilisateur", orphanRemoval=true)
     */
    private $likes;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return (string) $this->motDePasse;
    }

    public function setPassword(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($motDePasse)
    {
        $this->plainPassword = $motDePasse;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setAuteur($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getAuteur() === $this) {
                $question->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setAuteur($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
            // set the owning side to null (unless already changed)
            if ($reponse->getAuteur() === $this) {
                $reponse->setAuteur(null);
            }
        }

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function __toString()
    {
        return $this->pseudo;
    }

    /**
     * @return Collection|QuestionLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(QuestionLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUtilisateur($this);
        }

        return $this;
    }

    public function removeLike(QuestionLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getUtilisateur() === $this) {
                $like->setUtilisateur(null);
            }
        }

        return $this;
    }

}
