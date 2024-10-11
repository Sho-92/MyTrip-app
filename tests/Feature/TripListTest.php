<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TripPlan;
use App\Models\TripList;
use App\Models\Checklist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TripListTest extends TestCase
{
    use RefreshDatabase;

}