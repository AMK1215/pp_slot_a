<?php

namespace App\Http\Requests\PPSlot;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class PPSlotWebhookRequest extends FormRequest
{
    private ?User $member;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getMember()
    {
        if (! isset($this->member)) {
            $this->member = User::where('user_name', $this->getMemberName())->first();
        }

        return $this->member;
    }

    public function getMemberName()
    {
        return $this->get('MemberName');
    }

    public function getProductID()
    {
        return $this->get('ProductID');
    }

    public function getMessageID()
    {
        return $this->get('MessageID');
    }

    public function getMethodName()
    {
        return strtolower(str($this->url())->explode('/')->last());
    }

    public function getOperatorCode()
    {
        return $this->get('OperatorCode');
    }

    public function getRequestTime()
    {
        return $this->get('RequestTime');
    }

    public function getSign()
    {
        return $this->get('Sign');
    }

}