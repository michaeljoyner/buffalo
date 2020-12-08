<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductSearchQueryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_search_query_can_be_passed_as_a_url_parameter_gets_sent_to_search_page()
    {
        $this->withoutExceptionHandling();
        $this->asLoggedInUser();
        $response = $this->get("/admin/products/search?q=test-search");
        $response->assertStatus(200);

        $this->assertEquals("test-search", $response->viewData("query"));
    }

    /**
     *@test
     */
    public function the_query_exists_as_empty_when_not_included_in_url()
    {
        $this->asLoggedInUser();
        $response = $this->get("/admin/products/search");
        $response->assertStatus(200);

        $this->assertEquals("", $response->viewData("query"));
    }
}