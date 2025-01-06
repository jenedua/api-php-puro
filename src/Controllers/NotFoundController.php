<?php
    namespace App\Controllers;
    use App\Http\Response;
    use App\Http\Request;   

    class NotFoundController{
        public function index( Request $request, Response $response){
            $response::json([
                'Error'=> true,
                'Success'=> false,
                'message'=>'Sorry,route not found'
            ], 404);
        }
    }