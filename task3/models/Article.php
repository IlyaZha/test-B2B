<?php

/**
 * Class Article
 */
abstract class Article {

	/**
	 * Return the user of the article
	 *
	 * @return User
	 */
	public abstract function user() : User;

	/**
	 * @param User $newUser
	 * @return bool
	 */
	public abstract function changeUser(User $newUser) : bool;

}