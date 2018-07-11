<?php

/**
 * Class User
 */
abstract class User {

	/**
	 * @var int
	 */
	public $id;
	/**
	 * @var Article[]
	 */
	public $articles = [];

	/**
	 * @return Article
	 */
	public abstract function createArticle() : Article;

	/**
	 * Get all articles of the user
	 *
	 * @return Article[]
	 */
	public abstract function articles() : array;

}