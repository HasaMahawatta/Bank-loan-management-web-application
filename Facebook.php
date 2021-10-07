<?php

class Facebook
    {

    public $page_access_token = 'CAALNznFZBjSMBAEBaKKvpViFgR17omRzqBksJJ0zXuugMiJoPSNLhgE6qT128Eq5Y4HIyvbMcLrLurMMjS2YgYDf562NPAdeKsVQobcPuV90izPqJUqn6YrZBV092ZAjKPj4LBOWBjFIai8kw2plgR7kLvjfLjWXkmo7ehzDotR1Wijqpm8';
    public $page_id = '751483548298916';
    public $defaultImage = "http://hitroot.com/images/whitey.jpg";
    public $description = "Description";
    public $caption = "Caption";

    public function assign($caption, $description, $picture)
        {
        $this->defaults($caption, $description, $picture);
        }

    public function post($link, $message, $caption = "", $description = "", $picture = "")
        {
        $this->defaults($caption, $description, $picture);
        $data['link'] = $link;
        $data['message'] = $message;
        $data['caption'] = $this->caption;
        $data['picture'] = $this->defaultImage;
        $data['description'] = $this->description;
        $data['access_token'] = $this->page_access_token;
        $post_url = 'https://graph.facebook.com/' . $this->page_id . '/feed';
        $this->executeCurl($post_url, $data);
        }

    public function defaults($caption, $description, $picture)
        {
        if (strlen($description) > 0)
            {
            $this->description = $description;
            }
        if (strlen($picture) > 0)
            {
            $this->defaultImage = $picture;
            }
        if (strlen($caption) > 0)
            {
            $this->caption = $caption;
            }
        }

    public function extendToken()
        {
        $data['client_id'] = "789236504497443";
        $data['client_secret'] = "b29937c276475b35eb920348f4ec3164";
        $data['grant_type'] = 'fb_exchange_token';
        $data['fb_exchange_token'] = $this->page_access_token;
        $post_url = 'https://graph.facebook.com/oauth/access_token';
        $this->executeCurl($post_url, $data);
        }

    public function executeCurl($post_url, $data)
        {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($ch);
        curl_close($ch);
        echo $return;
        echo "Post Ok";
        }

    }

$facebook = new Facebook;
//$facebook->extendToken();
$facebook->post("hitroot.com", "Message","","",'http://hitroot.com/images/__back.jpg');
