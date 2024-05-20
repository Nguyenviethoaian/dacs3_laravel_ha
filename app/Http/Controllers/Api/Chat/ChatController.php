<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\GetChatRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetChatRequest $request)
    {
        $data = $request->validated();

        $isPrivate = 1;
        if ($request->has('is-private')) {
            $isPrivate = (int)$data['is_private'];
        }
        
        $chats = Chat::where('is_private', $isPrivate)
            ->hasParticipants(auth()->user()->id)
            ->whereHas('message')
            ->with('lastMessage.user', 'participants.user')
            ->latest('updated_at')
            ->get();

        return $this->success($chats);
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
{
    $data = $this->prepareStoreData($request);

    if ($data['userId'] === $data['otherUserId']) {
        return response()->json(['error' => 'Bạn không thể tạo cuộc trò chuyện với chính mình'], 400);
    }

    $previousChat = $this->getPreviousChat($data['otherUserId']);

    if ($previousChat === null) {
        $chat = Chat::create($data['data']);
        $chat->participants()->createMany([
            [
                'user_id' => $data['userId']
            ],
            [
                'user_id' => $data['otherUserId']
            ]
        ]);
        $chat->refresh()->load('lastMessage.user', 'participants.user');
        return response()->json(['chat' => $chat], 200);
    }

    if ($previousChat) {
        $previousChat->load('lastMessage.user', 'participants.user');
        return response()->json([$previousChat], 200);
    } else {
        return response()->json(['error' => 'Không tìm thấy cuộc trò chuyện trước đó'], 404);
    }
}

    private function getPreviousChat(int $otherUserId) : bool {
        $userId = auth()->user()->id;
        return Chat::where('is_private',1)
        ->whereHas('participants', function($query) use($userId){
            $query->where('user_id', $userId);})
        ->whereHas('participants', function($query) use($otherUserId){
            $query->where('user_id', $otherUserId);})
        ->first();
    }
    private function prepareStoreData(StoreRequest $request):array{
        $data= $request->validated();
        $otherUserId = (int)$data['user_id'];
        unset($data['user_id']);
        $data['created_by']=auth()->user()->id;

        return [
            'otherUserId'=>$otherUserId,
            'userId'=>auth()->user()->id,
            'data'=>$data,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat):JsonResponse{ 
        $chat->load('lastMessage.user','participants.user');
        return $this->success($chat);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
