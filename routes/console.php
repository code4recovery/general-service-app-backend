<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:import-gso-news')->hourly();
