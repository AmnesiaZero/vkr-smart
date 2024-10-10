<?php

namespace App\Services\Comments;

use App\Services\Comments\Repositories\CommentRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentsService extends Services
{
    private CommentRepositoryInterface $commentRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(CommentRepositoryInterface $commentRepository, UserRepositoryInterface $userRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
    }

    public function create(array $data): JsonResponse
    {
        $you = Auth::user();
        $senderId = $you->id;
        $data['sender_id'] = $senderId;
        $result = $this->commentRepository->create($data);
        if ($result and $result->id) {
            $id = $result->id;
            $comment = $this->commentRepository->find($id);
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'comment' => $comment
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Произошла ошибка при создании комментария'
        ]);
    }

    public function get(int $workId): JsonResponse
    {
        $comments = $this->commentRepository->get($workId);
        if ($comments) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'comments' => $comments
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при получении комментариев'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->commentRepository->delete($id);
        if ($flag) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Комментарий был успешно удален'
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при удалении комментария'
        ]);
    }
}
