<?php

namespace Tests\Unit\Http\v1\Channels;

use App\Channel;
use App\Http\Controllers\Api\v1\Channels\ChannelsController;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChannelsTest extends TestCase
{

    /**
     * Test return all channels
     */
    public function test_get_all_channels()
    {
        $response = $this->get(route('channels.all'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test a channel request to be validated
     */
    public function test_store_a_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Test a channel can stored on DB
     */
    public function test_a_channel_can_be_stored()
    {
        $response = $this->postJson(route('channel.store'), [
            'name' => 'React',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }


    /**
     * Test to update channel request to be validate
     */
    public function test_channel_should_be_validated()
    {
        $response = $this->json('PUT', route('channel.update'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test to update channel
     */
    public function test_a_channel_should_be_updated()
    {
        $channel = factory(Channel::class)->create();
        $response = $this->json('PUT', route('channel.update'), [
            'id'   => $channel->id,
            'name' => 'PHP',
        ]);
        $updatedChannel = Channel::query()->find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('PHP', $updatedChannel->name);
    }


    /**
     * Test a request to destroying a channel should be validated
     */
    public function test_a_channel_to_destroy_should_be_validated()
    {
        $response = $this->json('DELETE', route('channel.destroy'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test a channel should be destroyed.
     */
    public function test_a_channel_should_be_destroy()
    {
        $channel = factory(Channel::class)->create();
        $response = $this->json('DELETE', route('channel.destroy'), ['id' => $channel->id]);
        $response->assertStatus(Response::HTTP_OK);
    }
}