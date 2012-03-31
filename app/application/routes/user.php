<?php

return array(

   'GET /user/logout' => function()
   {
      Auth::logout();

      return Redirect::to('user/login');
   }

);