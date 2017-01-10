<?php
use App\Products\ProductGroup;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/2/16
 * Time: 9:25 AM
 */
class ProductGroupsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_product_group_can_be_added_to_a_subcategory_by_posting_to_an_endpoint()
    {
        $subcategory = factory(Subcategory::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('POST', '/admin/subcategories/' . $subcategory->id . '/productgroups', [
            'name'        => 'Groopy',
            'description' => 'Totally groopy baby'
        ]);
        $this->assertRedirectResponse($response);

        $this->seeInDatabase('product_groups', [
            'subcategory_id' => $subcategory->id,
            'name'           => 'Groopy',
            'description'    => 'Totally groopy baby'
        ]);
    }

    /**
     * @test
     */
    public function a_product_groups_name_and_description_may_be_edited()
    {
        $productGroup = factory(ProductGroup::class)->create();
        $this->asLoggedInUser();

        $this->visit('/admin/productgroups/' . $productGroup->id . '/edit')
            ->type('A new product group', 'name')
            ->type('A new description', 'description')
            ->press('Save Changes')
            ->seeInDatabase('product_groups', [
                'id'          => $productGroup->id,
                'name'        => 'A new product group',
                'description' => 'A new description'
            ]);
    }

    /**
     *@test
     */
    public function a_product_group_may_be_soft_deleted()
    {
        $productGroup = factory(ProductGroup::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('DELETE', '/admin/productgroups/' . $productGroup->id);
        $this->assertRedirectResponse($response);

        $this->assertSoftDeleted($productGroup);
    }

}