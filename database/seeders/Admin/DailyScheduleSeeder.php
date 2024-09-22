<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Schedules\DailySchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daily_schedules = array(
            array('id' => '1','admin_id' => '1','day_id' => '1','name' => 'Weekend Wake-Up Call','slug' => 'weekend-wake-up-call','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Sophie Carter','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'a07cfbe6-2c60-4e54-a45f-ec7254e5eef9.webp','status' => '1','start_time' => '07:00:00','end_time' => '09:00:00','created_at' => '2023-11-06 12:55:20','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '2','admin_id' => '1','day_id' => '1','name' => 'Country Crossroads','slug' => 'country-crossroads','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Jackson Brooks','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '92499c38-31e7-4e33-ad4f-c4fb43162906.webp','status' => '1','start_time' => '09:00:00','end_time' => '11:00:00','created_at' => '2023-11-06 12:55:55','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '3','admin_id' => '1','day_id' => '1','name' => 'Saturday Swing Sessions','slug' => 'saturday-swing-sessions','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Lily Evans','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '61684eb9-7e50-4cde-a425-2229fb72b04e.webp','status' => '1','start_time' => '11:00:00','end_time' => '01:00:00','created_at' => '2023-11-06 12:57:21','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '4','admin_id' => '1','day_id' => '1','name' => 'Pop Divas Hour','slug' => 'pop-divas-hour','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Chris Roberts','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'ed80f5e0-69bb-4b18-9c33-0560075fac26.webp','status' => '1','start_time' => '13:00:00','end_time' => '15:00:00','created_at' => '2023-11-06 12:58:02','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '5','admin_id' => '1','day_id' => '1','name' => 'Dancefloor Heat','slug' => 'dancefloor-heat','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Amelia Walker','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '3eebaca0-53e3-408e-b530-c4965911471f.webp','status' => '1','start_time' => '15:00:00','end_time' => '17:00:00','created_at' => '2023-11-06 12:59:06','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '6','admin_id' => '1','day_id' => '1','name' => 'Saturday Night Grooves','slug' => 'saturday-night-grooves','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Leo White','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '87644c6b-5a9c-4fb2-8dc7-73e7b38705d0.webp','status' => '1','start_time' => '17:00:00','end_time' => '19:00:00','created_at' => '2023-11-06 12:59:51','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '7','admin_id' => '1','day_id' => '2','name' => 'Sunday Serenity','slug' => 'sunday-serenity','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Olivia Clark','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'a07cfbe6-2c60-4e54-a45f-ec7254e5eef9.webp','status' => '1','start_time' => '08:00:00','end_time' => '10:00:00','created_at' => '2023-11-06 13:00:43','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '8','admin_id' => '1','day_id' => '2','name' => 'Gospel and Hymns','slug' => 'gospel-and-hymns','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Isabella Turner','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '92499c38-31e7-4e33-ad4f-c4fb43162906.webp','status' => '1','start_time' => '10:00:00','end_time' => '12:00:00','created_at' => '2023-11-06 13:02:07','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '9','admin_id' => '1','day_id' => '2','name' => 'Acoustic Sunday Brunch','slug' => 'acoustic-sunday-brunch','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Ethan Davis','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '61684eb9-7e50-4cde-a425-2229fb72b04e.webp','status' => '1','start_time' => '12:00:00','end_time' => '14:00:00','created_at' => '2023-11-06 13:02:50','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '10','admin_id' => '1','day_id' => '2','name' => 'Oldies Goldies','slug' => 'oldies-goldies','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Emma Turner','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'ed80f5e0-69bb-4b18-9c33-0560075fac26.webp','status' => '1','start_time' => '14:00:00','end_time' => '04:00:00','created_at' => '2023-11-06 13:03:32','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '11','admin_id' => '1','day_id' => '2','name' => 'Smooth Sunday Sunset','slug' => 'smooth-sunday-sunset','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Daniel Martin','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '3eebaca0-53e3-408e-b530-c4965911471f.webp','status' => '1','start_time' => '16:00:00','end_time' => '18:00:00','created_at' => '2023-11-06 13:04:17','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '12','admin_id' => '1','day_id' => '2','name' => 'Relaxation and Reflection','slug' => 'relaxation-and-reflection','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Sophia Johnson','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '87644c6b-5a9c-4fb2-8dc7-73e7b38705d0.webp','status' => '1','start_time' => '18:00:00','end_time' => '20:00:00','created_at' => '2023-11-06 13:05:50','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '13','admin_id' => '1','day_id' => '3','name' => 'Morning Melodies','slug' => 'morning-melodies','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Sarah Summers','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '2990708a-81d7-456b-8359-98b138f0baca.webp','status' => '1','start_time' => '08:00:00','end_time' => '10:00:00','created_at' => '2023-11-06 13:13:48','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '14','admin_id' => '1','day_id' => '3','name' => 'Indie Spotlight','slug' => 'indie-spotlight','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Alex Rivers','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '24d68531-d331-4332-a22a-e15573f1389f.webp','status' => '1','start_time' => '10:00:00','end_time' => '12:00:00','created_at' => '2023-11-06 13:14:28','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '15','admin_id' => '1','day_id' => '3','name' => 'Lunchtime Jazz Jam','slug' => 'lunchtime-jazz-jam','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Michael Davis','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '632327d9-b9d6-40ed-b981-5db50122829e.webp','status' => '1','start_time' => '12:00:00','end_time' => '14:00:00','created_at' => '2023-11-06 13:15:05','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '16','admin_id' => '1','day_id' => '3','name' => 'Throwback Classics','slug' => 'throwback-classics','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Emily Roberts','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'afbce36a-b37f-402c-a915-6e9341be38fc.webp','status' => '1','start_time' => '14:00:00','end_time' => '16:00:00','created_at' => '2023-11-06 13:15:55','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '17','admin_id' => '1','day_id' => '3','name' => 'Pop Hits Extravaganza','slug' => 'pop-hits-extravaganza','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Chris Taylor','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '1','image' => '8acb6053-6de4-4a10-ad9b-c25003f4c6eb.webp','status' => '1','start_time' => '16:00:00','end_time' => '18:00:00','created_at' => '2023-11-06 13:16:50','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '18','admin_id' => '1','day_id' => '3','name' => 'Evening Chillout','slug' => 'evening-chillout','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Olivia Mason','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '240143dc-05a6-4e64-bfeb-91bd1f16c8f4.webp','status' => '1','start_time' => '18:00:00','end_time' => '20:00:00','created_at' => '2023-11-06 13:17:33','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '19','admin_id' => '1','day_id' => '4','name' => 'Rise and Shine','slug' => 'rise-and-shine','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'David Clark','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '59e58f63-6ec1-4ca4-a229-371a1164454c.webp','status' => '1','start_time' => '07:00:00','end_time' => '09:00:00','created_at' => '2023-11-06 13:18:37','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '20','admin_id' => '1','day_id' => '4','name' => 'Acoustic Serenity','slug' => 'acoustic-serenity','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Lily Anderson','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'bef96ff3-2e91-403d-a565-5450ed9e17fb.webp','status' => '1','start_time' => '09:00:00','end_time' => '11:00:00','created_at' => '2023-11-06 13:25:41','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '21','admin_id' => '1','day_id' => '4','name' => 'Retro Revival','slug' => 'retro-revival','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'James White','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '04ea0b8c-0c5c-43ec-b04d-4a366548b6da.webp','status' => '1','start_time' => '11:00:00','end_time' => '13:00:00','created_at' => '2023-11-06 13:26:38','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '22','admin_id' => '1','day_id' => '4','name' => 'Afternoon Grooves','slug' => 'afternoon-grooves','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Rachel Hayes','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '0667b452-6605-45f2-81bc-26149aa54c9c.webp','status' => '1','start_time' => '13:00:00','end_time' => '15:00:00','created_at' => '2023-11-06 13:27:24','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '23','admin_id' => '1','day_id' => '4','name' => 'Chart-Toppers Countdown','slug' => 'chart-toppers-countdown','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Ethan Martin','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'af9a0465-5d05-4803-9b19-2291562bd670.webp','status' => '1','start_time' => '15:00:00','end_time' => '17:00:00','created_at' => '2023-11-06 13:28:19','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '24','admin_id' => '1','day_id' => '4','name' => 'Twilight Vibes','slug' => 'twilight-vibes','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Sophia Lee','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'e78665e8-5357-48dd-8971-26943a46507c.webp','status' => '1','start_time' => '17:00:00','end_time' => '19:00:00','created_at' => '2023-11-06 13:29:04','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '25','admin_id' => '1','day_id' => '5','name' => 'Early Bird Mix','slug' => 'early-bird-mix','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Daniel King','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '00eb1bdf-9737-4c5e-97b9-cc7ef0386502.webp','status' => '1','start_time' => '06:00:00','end_time' => '08:00:00','created_at' => '2023-11-06 13:29:44','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '26','admin_id' => '1','day_id' => '5','name' => 'World Music Expedition','slug' => 'world-music-expedition','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Isabella Cruz','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '3f14030e-3f61-49ba-8bc3-04f39ee665a8.webp','status' => '1','start_time' => '08:00:00','end_time' => '10:00:00','created_at' => '2023-11-06 13:30:27','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '27','admin_id' => '1','day_id' => '5','name' => 'Coffeehouse Acoustics','slug' => 'coffeehouse-acoustics','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Aiden Cooper','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '9b075946-d57c-4436-9561-acdabd169eaa.webp','status' => '1','start_time' => '10:00:00','end_time' => '12:00:00','created_at' => '2023-11-06 13:31:20','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '28','admin_id' => '1','day_id' => '5','name' => 'Classic Rock Anthems','slug' => 'classic-rock-anthems','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Lucy Turner','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '211a20fc-b149-4a03-9a22-71b14a3ed96b.webp','status' => '1','start_time' => '12:00:00','end_time' => '14:00:00','created_at' => '2023-11-06 13:32:06','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '29','admin_id' => '1','day_id' => '5','name' => 'Midweek Blues Break','slug' => 'midweek-blues-break','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Max Foster','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '98bfc476-35bd-4311-a43f-59fb6d182dff.webp','status' => '1','start_time' => '14:00:00','end_time' => '16:00:00','created_at' => '2023-11-06 14:35:50','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '30','admin_id' => '1','day_id' => '5','name' => 'Electric Dance Party','slug' => 'electric-dance-party','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Mia Garcia','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '3966c9ed-7020-4f23-bd99-18c8611c6c0e.webp','status' => '1','start_time' => '16:00:00','end_time' => '18:00:00','created_at' => '2023-11-06 14:35:31','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '31','admin_id' => '1','day_id' => '6','name' => 'Sunrise Serenade','slug' => 'sunrise-serenade','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Leo Roberts','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'baa1801a-670a-405b-8192-b9db79c4c4ea.webp','status' => '1','start_time' => '07:30:00','end_time' => '09:30:00','created_at' => '2023-11-06 14:36:43','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '32','admin_id' => '1','day_id' => '6','name' => 'Latin Fiesta','slug' => 'latin-fiesta','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Sofia Rodriguez','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '56c001e7-c60e-4141-930f-e1222835a399.webp','status' => '1','start_time' => '09:30:00','end_time' => '11:30:00','created_at' => '2023-11-06 14:37:21','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '33','admin_id' => '1','day_id' => '6','name' => 'Soulful Rhythms','slug' => 'soulful-rhythms','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Marcus Johnson','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '9d9433e9-0cbd-4f64-8192-e94200b2dbf6.webp','status' => '1','start_time' => '11:30:00','end_time' => '13:30:00','created_at' => '2023-11-06 14:38:28','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '34','admin_id' => '1','day_id' => '6','name' => 'Midday Mixtape','slug' => 'midday-mixtape','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Ava Martinez','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '23787905-636a-404f-8df7-6834062ba527.webp','status' => '1','start_time' => '13:30:00','end_time' => '15:30:00','created_at' => '2023-11-06 14:39:11','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '35','admin_id' => '1','day_id' => '6','name' => 'Rock Legends Hour','slug' => 'rock-legends-hour','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Dylan Walker','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '059612ee-ed62-47f5-80bf-60ce4dbfe3fe.webp','status' => '1','start_time' => '15:30:00','end_time' => '17:30:00','created_at' => '2023-11-06 14:39:50','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '36','admin_id' => '1','day_id' => '6','name' => 'Reggae Relaxation','slug' => 'reggae-relaxation','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Zoe Baker','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '9e3eff15-bc19-40a4-9246-ca797553744a.webp','status' => '1','start_time' => '17:30:00','end_time' => '19:30:00','created_at' => '2023-11-06 14:40:36','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '37','admin_id' => '1','day_id' => '7','name' => 'Morning Bliss','slug' => 'morning-bliss','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Mia Thompson','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => 'd7a14d2d-f89c-4c4b-9dc5-b1e35b7438a9.webp','status' => '1','start_time' => '08:00:00','end_time' => '10:00:00','created_at' => '2023-11-06 14:41:20','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '38','admin_id' => '1','day_id' => '7','name' => 'EDM Extravaganza','slug' => 'edm-extravaganza','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Oliver Harris','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '8dc9dbb2-0d34-404d-97b5-a09c95cc7b80.webp','status' => '1','start_time' => '10:00:00','end_time' => '12:00:00','created_at' => '2023-11-06 14:41:59','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '39','admin_id' => '1','day_id' => '7','name' => 'Coffee Break Classics','slug' => 'coffee-break-classics','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Emma Davis','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '3ca9c4f7-7d9a-48bd-b263-1aa1d954c7b2.webp','status' => '1','start_time' => '12:00:00','end_time' => '14:00:00','created_at' => '2023-11-06 14:42:34','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '40','admin_id' => '1','day_id' => '7','name' => 'Friday Feel-Good Hits','slug' => 'friday-feel-good-hits','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Liam Miller','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '0ceca1f5-8eee-4de7-b30b-2849904093ad.webp','status' => '1','start_time' => '14:00:00','end_time' => '16:00:00','created_at' => '2023-11-06 14:43:08','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '41','admin_id' => '1','day_id' => '7','name' => 'Weekend Warm-Up','slug' => 'weekend-warm-up','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Chloe Adams','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '00af3909-d453-4f17-90e1-b39911e960af.webp','status' => '1','start_time' => '16:00:00','end_time' => '18:00:00','created_at' => '2023-11-06 14:43:45','updated_at' => '2023-11-06 17:15:01'),
            array('id' => '42','admin_id' => '1','day_id' => '7','name' => 'Friday Night Groove','slug' => 'friday-night-groove','chat_link' => 'http://localhost/adradio-v1.0/admin/schedule/index','radio_link' => 'https://live.bromyardfm.uk/listen/bromyardfm/radio.mp3','host' => 'Max Turner','description' => 'Relax and unwind with the soothing sounds of ‘Smooth Jazz Serenade.’ Let the mellow melodies transport you to a world of pure relaxation and tranquility.','is_live' => '0','image' => '30722849-070e-4cc7-834f-851560111032.webp','status' => '1','start_time' => '18:00:00','end_time' => '20:00:00','created_at' => '2023-11-06 14:44:21','updated_at' => '2023-11-06 17:15:01')
          );




        DailySchedule::insert($daily_schedules);
    }
}
