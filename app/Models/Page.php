<?php

namespace App\Models;

class Page {
    protected $title;
    protected $published;
    protected $slug;
    protected $subHead;
    protected $body;
    protected $mTime;

    /**
     * @param $title
     * @param $published
     * @param $slug
     * @param $body
     * @param $mTime
     */
    public function __construct($title, $published, $slug, $subHead, $body, $mTime) {
        $this->title = $title;
        $this->published = $published;
        $this->slug = $slug;
        $this->subHead = $subHead;
        $this->body = $body;
        $this->mTime = $mTime;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * @return mixed
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getSubHead() {
        return $this->subHead;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getMTime() {
        return $this->mTime;
    }


}
