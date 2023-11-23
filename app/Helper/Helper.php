<?php

namespace App\Helper;
use App\Models\Post;
use App\Models\Page;
use App\Models\Group;
use Carbon\Carbon;

class Helper 
{
    public static function setupData($facebook_id, $facebook_token, $userId)
    {
        $page_url = "https://graph.facebook.com/v18.0/".$facebook_id."/accounts?access_token=".$facebook_token."&fields=picture,id,name,access_token";

        $client = new \GuzzleHttp\Client();
        $response = $client->get($page_url);
        $body = $response->getBody();
        $datas = json_decode($body);

        foreach ($datas->data as $data) {
            Page::updateOrCreate(['page_id' => $data->id],
                [
                'user_id' => $userId,
                'page_id'=> $data->id,
                'page_name'=> $data->name,
                'image_url'=> $data->picture->data->url,
                'page_access_token' =>$data->access_token
            ]);

            $post_url = "https://graph.facebook.com/v18.0/".$data->id."/feed?limit=100&access_token=".$data->access_token;
            $res = $client->get($post_url);
            $resBody = $res->getBody();
            $posts = json_decode($resBody);

            foreach ($posts->data as $post) {
                $images_url = "https://graph.facebook.com/v18.0/".$post->id."/?access_token=".$data->access_token."&fields=attachments";
                $comment_url = "https://graph.facebook.com/v18.0/".$post->id."/?access_token=".$data->access_token."&fields=comments.limit(100).summary(true)";
                $like_url = "https://graph.facebook.com/v18.0/".$post->id."/?access_token=".$data->access_token."&fields=likes.limit(100).summary(true)";

                $resImage = $client->get($images_url);
                $imageBody = $resImage->getBody();
                $imagedata = json_decode($imageBody);

                $image = null;
                $images = null;
                if ($imagedata && isset($imagedata->attachments)) {
                    if (isset($imagedata->attachments->data[0]) && isset($imagedata->attachments->data[0]->media->image->src)) {
                        $image = $imagedata->attachments->data[0]->media->image->src;
                    }
                    if (isset($imagedata->attachments->data[0]) && isset($imagedata->attachments->data[0]->subattachments)) {
                        $images = [];
                        $imageArr = $imagedata->attachments->data[0]->subattachments;
                        foreach ($imageArr->data as $i) {
                            if (isset($i->media->image->src)) {
                                $images[] = $i->media->image->src;
                            }
                        }
                    }
                }

                $resComment = $client->get($comment_url);
                $commentBody = $resComment->getBody();
                $comments = json_decode($commentBody);

                $resLike = $client->get($like_url);
                $likeBody = $resLike->getBody();
                $likes = json_decode($likeBody);

                Post::updateOrCreate(['post_id' => $post->id],
                    [
                    'user_id' => $userId,
                    'page_id'=> $data->id,
                    'post_id'=> $post->id,
                    'message'=> optional($post)->message ?? optional($post)->story,
                    'comments'=> $comments->comments->summary->total_count,
                    'likes'=> $likes->likes->summary->total_count,
                    'image'=> $image,
                    'images'=> $images,
                    'created_time' => Carbon::parse($post->created_time)->format('Y-m-d H:i:s')
                ]);
            }
        }

        $group_url = "https://graph.facebook.com/v18.0/".$facebook_id."/groups?access_token=".$facebook_token;
        $resGroup = $client->get($group_url);
        $groupBody = $resGroup->getBody();
        $groups = json_decode($groupBody);

        foreach ($groups->data as $data) {
            Group::updateOrCreate(['group_id' => $data->id],
                [
                'user_id' => $userId,
                'group_id'=> $data->id,
                'group_name'=> $data->name
            ]);
        }
    }
}