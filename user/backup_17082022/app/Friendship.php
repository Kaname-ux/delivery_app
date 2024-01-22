<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected function friendsOfThisUser()
	{
		return $this->belongsToMany(User::class, ‘friendships’, ‘first_user’, ‘second_user’)
		->withPivot(‘status’)
		->wherePivot(‘status’, ‘confirmed’);
	}
 
	// friendship that this user was asked for
	protected function thisUserFriendOf()
	{
		return $this->belongsToMany(User::class, ‘friendships’, ‘second_user’, ‘first_user’)
		->withPivot(‘status’)
		->wherePivot(‘status’, ‘confirmed’);
	}
 
	// accessor allowing you call $user->friends
	public function getFriendsAttribute()
	{
		if ( ! array_key_exists(‘friends’, $this->relations)) $this->loadFriends();
		return $this->getRelation(‘friends’);
	}
 
	protected function loadFriends()
	{
		if ( ! array_key_exists(‘friends’, $this->relations))
		{
		$friends = $this->mergeFriends();
		$this->setRelation(‘friends’, $friends);
	}
	}
 
	protected function mergeFriends()
	{
		if($temp = $this->friendsOfThisUser)
		return $temp->merge($this->thisUserFriendOf);
		else
		return $this->thisUserFriendOf;
	}


	// friendship that this user started but now blocked
	protected function friendsOfThisUserBlocked()
	{
		return $this->belongsToMany(User::class, ‘friendships’, ‘first_user’, ‘second_user’)
					->withPivot(‘status’, ‘acted_user’)
					->wherePivot(‘status’, ‘blocked’)
					->wherePivot(‘acted_user’, ‘first_user’);
	}
 
	// friendship that this user was asked for but now blocked
	protected function thisUserFriendOfBlocked()
	{
		return $this->belongsToMany(User::class, ‘friendships’, ‘second_user’, ‘first_user’)
					->withPivot(‘status’, ‘acted_user’)
					->wherePivot(‘status’, ‘blocked’)
					->wherePivot(‘acted_user’, ‘second_user’);
	}
 
	// accessor allowing you call $user->blocked_friends
	public function getBlockedFriendsAttribute()
	{
		if ( ! array_key_exists(‘blocked_friends’, $this->relations)) $this->loadBlockedFriends();
			return $this->getRelation(‘blocked_friends’);
	}
 
	protected function loadBlockedFriends()
	{
		if ( ! array_key_exists(‘blocked_friends’, $this->relations))
		{
			$friends = $this->mergeBlockedFriends();
			$this->setRelation(‘blocked_friends’, $friends);
		}
	}
 
	protected function mergeBlockedFriends()
	{
		if($temp = $this->friendsOfThisUserBlocked)
			return $temp->merge($this->thisUserFriendOfBlocked);
		else
			return $this->thisUserFriendOfBlocked;
	}
// ======================================= end functions to get block_friends attribute =========

   public function friend_requests()
{
	return $this->hasMany(Friendship::class, ‘second_user’)
	->where(‘status’, ‘pending’);
}

public static function checkfriendship($first_user, $second_user, $user_id)
{
  $relashion = $this->where('acted_user', $user_id)->where('second_user', $second_user)->where('first_user', $user_id)->first();

  $reverse_relation =  $this->where('acted_user', $second_user)->where('second_user', $user_id)->where('first_user', $second_user)->first();

  if($relation && !$reverse_relation)

  {
        if($relation->status == "approuved")
          {echo "Est mon livreur";}

        if($relation->status == "pending")
          {echo "Demande en attente";}
        if($relation->status == "blocked")
          {echo "Livreur bloqué <button>Debloquer</button>";}
  }
    else
    {
       if($reverse_relation)
         {
          if($reverse_relation->status == "approuved")
          {echo "Est mon livreur";}

        if($reverse_relation->status == "pending")
          {echo "Vous a envoyé une demande <button>Accepter</button><button>Refuser</button>";}
        if($relation->status == "blocked")
          {echo "Vendeur bloqué <button>Debloquer</button>";}
         }

         else{
          echo '<form action="/send_friend_request" method="POST">
                            <input value="{{$user_id}}" hidden type="text" name="first_user">
                            <input value="{{$second_user}}" hidden type="text" name="second_user">
                          <button type="submit" class="btn btn-success btn-sm">Ajouter à mes livreurs</button>
                          </form>';
         }
    }
} 
}
