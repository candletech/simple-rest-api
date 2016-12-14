<?php

class Controller {

    /**
     * @return array
     */
    protected function getPostBody() {
        $params = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $inputJSON = file_get_contents('php://input');
            $params = json_decode($inputJSON, TRUE);

            if($params == NULL) {
                $params = $_POST;
            }
        }

        return $params;
    }
}