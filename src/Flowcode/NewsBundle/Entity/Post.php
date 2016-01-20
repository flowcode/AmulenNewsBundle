<?php

namespace Flowcode\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Post
 */
class Post {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="abstract", type="text")
     */
    protected $abstract;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

    /**
     * @ManyToOne(targetEntity="Amulen\MediaBundle\Entity\Media", cascade={"persist"})
     * @JoinColumn(name="image_id", referencedColumnName="id", nullable=true)
     * */
    protected $image;

    /**
     * @ManyToMany(targetEntity="Amulen\ClassificationBundle\Entity\Tag")
     * @JoinTable(name="news_post_tag",
     *      joinColumns={@JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     * */
    protected $tags;

    /**
     * @var integer
     *
     * @ORM\Column(name="view_count", type="integer")
     */
    protected $viewCount;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public function __construct() {
        $this->tags = new ArrayCollection();
        $this->viewCount = 0;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setAbstract($abstract) {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string
     */
    public function getAbstract() {
        return $this->abstract;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * Add tags
     *
     * @param \Amulen\ClassificationBundle\Entity\Tag $tags
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function addTag($tags) {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Amulen\ClassificationBundle\Entity\Tag $tags
     */
    public function removeTag(\Amulen\ClassificationBundle\Entity\Tag $tags) {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Collection
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Set image
     *
     * @param \Amulen\MediaBundle\Entity\Media $image
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setImage(\Amulen\MediaBundle\Entity\Media $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Amulen\MediaBundle\Entity\Media
     */
    public function getImage() {
        return $this->image;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updated
     *
     * @param \DateTime $viewCount
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * Get viewCount
     *
     * @return integer
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }
}
