<?php


use App\Presenters\QuoteItemPresenter;
use App\Quotes\QuoteItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuoteItemPresenterTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function a_quote_item_is_presentable()
    {
        $item = factory(QuoteItem::class)->create();

        $presenter = $item->present(QuoteItemPresenter::class);

        $this->assertInstanceOf(QuoteItemPresenter::class, $presenter);
    }

    /**
     *@test
     */
    public function it_can_present_the_product_image_if_it_exists()
    {
        $product = factory(\App\Products\Product::class)->create();
        $image = $product->setImage($this->prepareFileUpload('tests/testpic1.png'));
        $item = factory(QuoteItem::class)->create(['product_id' => $product->id]);

        $presenter = $item->present(QuoteItemPresenter::class);
        $filePath = $presenter->imageSrc;
        $this->assertContains($product->imageSrc('thumb'), $filePath);
        $this->assertTrue(file_exists($filePath));

        unlink($filePath);
    }

    /**
     *@test
     */
    public function a_presented_item_still_has_its_models_attributes()
    {
        $item = factory(QuoteItem::class)->create();
        $presenter = $item->present(QuoteItemPresenter::class);

        $this->assertEquals($item->factory_number, $presenter->factory_number);
    }

    /**
     *@test
     */
    public function it_presents_the_packaging_summary()
    {
        $item = $this->makePresenterForQuoteItem(['package_unit' => 'PC', 'package_type' => 'Slide Card']);

        $this->assertEquals('1PC/Slide Card', $item->packaging_summary);
    }

    /**
     *@test
     */
    public function it_presents_the_inner_packaging()
    {
        $item = $this->makePresenterForQuoteItem(['package_unit' => 'PC', 'package_inner' => 24]);

        $this->assertEquals('24PC', $item->inner_package);
    }

    /**
     *@test
     */
    public function it_presents_the_outer_packaging()
    {
        $item = $this->makePresenterForQuoteItem(['package_unit' => 'PC', 'package_outer' => 96, 'package_carton' => 10]);

        $this->assertEquals('96PC/CTN/10 cu\'ft', $item->outer_package);
    }

    /**
     *@test
     */
    public function it_presents_the_items_weights()
    {
        $item = $this->makePresenterForQuoteItem(['net_weight' => 1.2, 'gross_weight' => 1.8]);

        $this->assertEquals('1.20kg/1.80kg', $item->weights);
    }

    /**
     *@test
     */
    public function it_presents_the_moq_with_the_units()
    {
        $item = $this->makePresenterForQuoteItem(['moq' => 300, 'package_unit' => 'PC']);

        $this->assertEquals('300PC', $item->moq);
    }

    /**
     *@test
     */
    public function it_presents_the_selling_price()
    {
        $item = $this->makePresenterForQuoteItem(['selling_price' => 132.51119, 'package_unit' => 'PC']);

        $this->assertEquals('$132.51/PC', $item->selling_price);
    }

    /**
     *@test
     */
    public function it_presents_the_description_of_the_item_as_plain_text_with_line_breaks()
    {
        $html = '<div>Line one</div><div>Line two</div><div>Line three</div><div>Line four</div>';
        $item = $this->makePresenterForQuoteItem(['description' => $html]);
        $expected = "Line one\nLine two\nLine three\nLine four";
        $this->assertEquals($expected, $item->description);
    }

    /**
     *@test
     */
    public function it_properly_handles_tables_in_the_description()
    {
        $html = '<table><thead><tr><th>No</th><th>Words</th></tr></thead><tbody><tr><td>1</td><td>Hello</td></tr><tr><td>2</td><td>Goodbye</td></tr></tbody></table>';
        $expectedText = "NoWords\n1Hello\n2Goodbye";

        $item = $this->makePresenterForQuoteItem(['description' => $html]);

        $this->assertEquals($expectedText, $item->description);
    }


    protected function makePresenterForQuoteItem($itemAttributres = [])
    {
        $item = factory(QuoteItem::class)->create($itemAttributres);
        $presenter = $item->present(QuoteItemPresenter::class);

        return $presenter;
    }

    /**
     *@test
     */
    public function it_presents_the_height_of_the_complete_description_as_20_px_per_line_plus_20_extra()
    {
        $html = '<div>Line one</div><div>Line two</div><div>Line three</div><div>Line four</div>';
        $item = $this->makePresenterForQuoteItem(['description' => $html]);
        //title + blank line + 4 lines of item description plus blank line plus 5 lines of packaging = 13 lines
        $this->assertEquals(260, $item->description_height);

        $fiveLines = "Line one\nLine two\nLine three\nLine four\nLine five";
        $item2 = $this->makePresenterForQuoteItem(['description' => $fiveLines]);
        //title + blank line  + 5 lines of item description plus blank line plus 5 lines of packaging = 14 lines
        $this->assertEquals(280, $item2->description_height);
    }
}