<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

#[Layout('layouts.app')]
class Contactus extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $message = '';
    public $inquiry_type = 'general';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10|max:1000',
        'inquiry_type' => 'required|in:general,product,support,partnership,bulk-order'
    ];

    protected $messages = [
        'name.required' => 'Name is required',
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'subject.required' => 'Subject is required',
        'message.required' => 'Message is required',
        'message.min' => 'Message must be at least 10 characters',
        'message.max' => 'Message cannot exceed 1000 characters',
    ];

    public function submitForm()
    {
        $this->validate();

        try {
            // Here you would typically save to database and/or send email
            // For now, we'll just simulate successful submission
            
            // You can implement email sending like this:
            // Mail::to('contact@yourssnacks.com')->send(new ContactFormMail($this->all()));
            
            session()->flash('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
            
            // Reset form
            $this->reset(['name', 'email', 'phone', 'subject', 'message', 'inquiry_type']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. Please try again or contact us directly.');
        }
    }

    public function render()
    {
        return view('livewire.public.contactus');
    }
}
