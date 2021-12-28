<?php

namespace App\Http\Controllers\Api;

use App\Email;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailResource;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $searchBy = $request->get('searchBy');

        $emails = null;
        $paginate = 15;
        if ($search && in_array($searchBy, ['sender', 'recipient', 'subject'])) {
            $emails = Email::where($searchBy, 'like', "%$search%")->orderBy('created_at', 'desc')->paginate($paginate);
        } else {
            $emails = Email::orderBy('created_at', 'desc')->paginate($paginate);
        }

        return EmailResource::collection($emails);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sender' => 'required|email',
            'recipient' => 'required|email',
            'subject' => 'required|max:255',
            'text' => 'required',
            'html' => 'required',
            'attachments' => 'array',
            'attachments.*' => 'file',
        ]);

        if (isset($validatedData['attachments'])) {
            $totalSize = 0;
            foreach ($validatedData['attachments'] as $attachment) {
                /** @var UploadedFile $attachment */
                $totalSize += $attachment->getSize();
                if ($totalSize > 25 * 1024 * 1024) {
                    throw ValidationException::withMessages(['attachments' => 'The total maximum file size is 25MB']);
                }
            }

            $attachments = [];
            foreach ($validatedData['attachments'] as $attachment) {
                /** @var UploadedFile $attachment */
                $attachments[] = $attachment->store('attachments', ['disk' => 'public']);
            }

            $validatedData = array_merge($validatedData, ['attachments' => $attachments]);
        }

        // Assuming that a separate email service will change the status later
        $validatedData['status'] = 'posted';

        // For now we send only the text version of the message
        $isSent = mail($validatedData['recipient'], $validatedData['subject'], $validatedData['text']);

        $validatedData['status'] = $isSent ? 'sent' : 'failed';

        return Email::create($validatedData);
    }

    public function show(Email $email)
    {
        return new EmailResource($email);
    }
}
