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
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * Post
 */
class Post
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"public_api"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Groups({"public_api"})
     */
    protected $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @Groups({"public_api"})
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="abstract", type="text")
     * @Groups({"public_api"})
     */
    protected $abstract;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @Groups({"public_api"})
     */
    protected $enabled;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Groups({"public_api"})
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    protected $video;
    /**
     * @var string
     *
     * @ORM\Column(name="video_code", type="string", length=255, nullable=true)
     */
    protected $videoCode;
    /**
     * @ManyToMany(targetEntity="Amulen\ClassificationBundle\Entity\Tag")
     * @JoinTable(name="news_post_tag",
     *      joinColumns={@JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     * */
    protected $tags;

    /**
     * @ManyToOne(targetEntity="Amulen\ClassificationBundle\Entity\Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     * */
    protected $category;

    /**
     * @var integer
     *
     * @ORM\Column(name="view_count", type="integer")
     */
    protected $viewCount;

    /**
     * @var datetime $published
     *
     * @ORM\Column(type="datetime")
     * @Groups({"public_api"})
     */
    protected $published;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"public_api"})
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"public_api"})
     */
    protected $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     * @Groups({"public_api"})
     */
    protected $type;


    /**
     * @var integer
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="smallint")
     */
    protected $position;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->viewCount = 0;
        $this->published = new \DateTime();
        $this->position = 0;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Add tags
     *
     * @param \Amulen\ClassificationBundle\Entity\Tag $tags
     * @return \Amulen\NewsBundle\Entity\Post
     */
    public function addTag($tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Amulen\ClassificationBundle\Entity\Tag $tags
     */
    public function removeTag(\Amulen\ClassificationBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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

    /**
     * @return datetime
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param datetime $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * Set category
     *
     * @param \Amulen\ClassificationBundle\Entity\Category $category
     * @return Post
     */
    public function setCategory(\Amulen\ClassificationBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Amulen\ClassificationBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Post
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set videoCode
     *
     * @param string $videoCode
     *
     * @return Post
     */
    public function setVideoCode($videoCode)
    {
        $this->videoCode = $videoCode;

        return $this;
    }

    /**
     * Get videoCode
     *
     * @return string
     */
    public function getVideoCode()
    {
        return $this->videoCode;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return LawCategory
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    

}
