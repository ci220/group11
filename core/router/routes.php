<?php
return [
  '/' => basePath('ui/home/home_page.php'),
  '/faq' => basePath('ui/faq/faq.php'),
  '/about' => basePath('ui/about/about.php'),
  '/guidelines' => basePath('ui/guidelines/guidelines.php'),
  '/contact' => basePath('ui/contact/contact.php'),
  '/profile' => basePath('ui/profile/userprofile.php'),
  '/profile/edit' => basePath('ui/profile/edit_userprofile.php'),
  '/login' => basePath('ui/login/login.php'),
  '/register' => basePath('ui/register/register.php'),
  '/logout' => basePath('ui/logout/logout.php'),
  '/profile/delete' => basePath('ui/profile/delete_userprofile.php'),
  '/friends' => basePath('ui/friends/friends_list.php'),
  '/friends/search' => basePath('ui/friends/search_users.php'),
  '/friends/add' => basePath('ui/friends/add_friend.php'),
  '/friends/delete' => basePath('ui/friends/delete_friend.php'),
  '/notifications' => basePath('ui/inbox/inbox.php'),
  '/notifications/accept' => basePath('ui/inbox/accept_friend.php'),
  '/post/create' => basePath('ui/post/create_post.php'),
  '/mypost' => basePath('ui/post/mypost.php'),
  '/posts' => basePath('ui/post/post.php'),
  '/posts/create' => basePath('ui/post/create_post.php'),
  '/posts/edit' => basePath('ui/post/edit_post.php'),
  '/posts/delete' => basePath('ui/post/delete_post.php'),
  '/posts/like' => basePath('ui/post/like_post.php'),
  '/myposts' => basePath('ui/post/mypost.php'),
  '/chat' => basePath('ui/chat/chat.php'),
  '/chat/send' => basePath('ui/chat/send_message.php'),
  '/chat/messages' => basePath('ui/chat/fetch_message.php'),
  '/forum' => basePath('ui/forum/forum_category.php'),
  '/forum/discussions' => basePath('ui/forum/discussion_list.php'),
  '/forum/discussion' => basePath('ui/discussion_detail/discussion_details.php'),
  '/forum/comment/save' => basePath('ui/discussion_detail/save_comment.php'),
  '/forum/comment/delete' => basePath('ui/discussion_detail/delete_comment.php'),
  '/forum/create' => basePath('ui/forum/create_discussion.php'),
  '/forum/store' => basePath('ui/forum/store_discussion.php'),
  '/verify-otp' => basePath('ui/register/otp.php'),
  '/profile/change-password' => basePath('ui/profile/change_password.php'),
];