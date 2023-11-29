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
        $page_url = "https://graph.facebook.com/v18.0/".$facebook_id."/accounts?access_token=".$facebook_token."&fields=picture,id,name,access_token,fan_count";

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
                'fan_count'=> $data->fan_count,
                'page_access_token' =>$data->access_token
            ]);

            $param = "attachments,created_time,story,message,shares,status_type,comments.limit(100).summary(true),insights.metric(post_reactions_by_type_total)";
            $post_url = "https://graph.facebook.com/v18.0/".$data->id."/feed?fields=".$param."&access_token=".$data->access_token;
            $res = $client->get($post_url);
            $resBody = $res->getBody();
            $posts = json_decode($resBody);

            foreach ($posts->data as $post) {
                if ($post) {
                    $image = null;
                    $images = null;
                    if ($post && isset($post->attachments)) {
                        if (isset($post->attachments->data[0]) && isset($post->attachments->data[0]->media->image->src)) {
                            $image = $post->attachments->data[0]->media->image->src;
                        }
                        if (isset($post->attachments->data[0]) && isset($post->attachments->data[0]->subattachments)) {
                            $images = [];
                            $imageArr = $post->attachments->data[0]->subattachments;
                            foreach ($imageArr->data as $i) {
                                if (isset($i->media->image->src)) {
                                    $images[] = $i->media->image->src;
                                }
                            }
                        }
                    }

                    $shares = 0;
                    if ($post && isset($post->shares)) {
                        $shares = $post->shares->count;
                    }

                    $reaction = $post->insights->data[0]->values[0]->value;
    
                    Post::updateOrCreate(['post_id' => $post->id],
                        [
                        'user_id' => $userId,
                        'page_id'=> $data->id,
                        'post_id'=> $post->id,
                        'message'=> optional($post)->message ?? optional($post)->story,
                        'comments'=> $post->comments->summary->total_count,
                        'status_type'=> $post->status_type,
                        'Liked'=> $reaction->like ?? 0,
                        'Love'=> $reaction->love ?? 0,
                        'Haha'=> $reaction->haha ?? 0,
                        'Wow'=> $reaction->wow ?? 0,
                        'Angry'=> $reaction->anger ?? 0,
                        'Sad'=> $reaction->sorry ?? 0,
                        'Care'=> $reaction->care ?? 0,
                        'shared'=> $shares,
                        'image'=> $image,
                        'images'=> $images,
                        'created_time' => Carbon::parse($post->created_time)->format('Y-m-d H:i:s')
                    ]);
                }
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