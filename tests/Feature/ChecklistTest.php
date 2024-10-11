<?php

namespace Tests\Feature;

use App\Models\Checklist;
use App\Models\TripPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ChecklistTest extends TestCase
{
    use RefreshDatabase;

}