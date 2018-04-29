<?php

namespace Tests\Feature;


use App\Category;
use App\Contributor;
use App\Meditation;
use Illuminate\Database\Eloquent\Model;

class MeditationsTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $resourceType = 'meditations';

    /**
     * Test the search route.
     */
    public function testSearch()
    {
        // ensure there is at least one season in the database
        $this->model();

        $this->doSearch()
            ->assertSearchResponse();
    }

    /**
     * Test searching for specific ids
     */
    public function testSearchById()
    {
        $models = factory(Meditation::class, 2)->create();
        // This season should not be returned in the results
        $this->model();

        $this->doSearchById($models)
            ->assertSearchByIdResponse($models);
    }

    /**
     * Test the create resource route.
     */
    public function testCreate()
    {
        $model = $this->model(false);

        $data = [
            'type' => 'meditations',
            'attributes' => [
                'title' => $model->title,
                'description' => $model->description,
                'image-url' => $model->image_url,
                'media-url' => $model->media_url,
                'published-at' => $model->published_at ? $model->published_at->format('c') : null,
                'status' => $model->status
            ]
        ];

        $id = $this
            ->doCreate($data)
            ->assertCreateResponse($data);

        $this->assertModelCreated($model, $id, ['title', 'description', 'image_url', 'media_url', 'published_at', 'status']);
    }

    /**
     * Test the read resource route.
     */
    public function testRead()
    {
        $model = $this->model();

        $contributorsData = [];
        foreach ($model->contributors as $contributor) {
            $contributorsData[] = [
                'type' => 'contributors',
                'id' => $contributor->getKey()
            ];
        }

        $data = [
            'type' => 'meditations',
            'id' => $model->getKey(),
            'attributes' => [
                'created-at' => $model->created_at->format('c'),
                'updated-at' => $model->updated_at->format('c'),
                'title' => $model->title,
                'description' => $model->description,
                'image-url' => $model->image_url,
                'media-url' => $model->media_url,
                'published-at' => $model->published_at ? $model->published_at->format('c') : null,
                'status' => $model->status
            ],
            'relationships' => [
                'category' => [
                    'data' => [
                        'type' => 'categories',
                        'id' => $model->category->getKey(),
                    ],
                ],
                'contributors' => [
                    'data' => $contributorsData,
                    'meta' => [
                        'total' => count($contributorsData)
                    ]
                ]
            ]
        ];

        $this->doRead($model)
            ->assertReadResponse($data);
    }

    /**
     * Test the update resource route.
     */
    public function testUpdate()
    {
        $model = $this->model();

        $data = [
            'type' => 'meditations',
            'id' => (string) $model->getKey(),
            'attributes' => [
                'title' => 'Foo',
            ],
        ];

        $responseDate = $this->doUpdate($data)->assertUpdateResponse($data)->getDate();
        $this->assertModelPatched($model, [
            'title' => 'Foo',
            'updated_at' => $responseDate
        ], ['created_at', 'description', 'image_url', 'media_url', 'published_at', 'status']);
    }

    /**
     * Test the delete resource route.
     */
    public function testDelete()
    {
        $model = $this->model();

        $this->doDelete($model)->assertDeleteResponse();
        $this->assertModelDeleted($model);
    }

    /**
     * Test the read category route.
     */
    public function testReadCategory()
    {
        $model = $this->model();

        $category = $model->category;

        $contributorsData = [];
        foreach ($category->contributors as $contributor) {
            $contributorsData[] = [
                'type' => 'contributors',
                'id' => $contributor->getKey()
            ];
        }

        $meditationsData = [];
        foreach ($category->meditations as $meditation) {
            $meditationsData[] = [
                'type' => 'meditations',
                'id' => $meditation->getKey()
            ];
        }

        $data = [
            'type' => 'categories',
            'id' => $category->getKey(),
            'attributes' => [
                'created-at' => $category->created_at->format('c'),
                'updated-at' => $category->updated_at->format('c'),
                'title' => $category->title,
                'description' => $category->description,
                'image-url' => $category->image_url
            ],
            'relationships' => [
                'meditations' => [
                    'data' => $meditationsData,
                    'meta' => [
                        'total' => count($meditationsData)
                    ]
                ],
                'contributors' => [
                    'data' => $contributorsData,
                    'meta' => [
                        'total' => count($contributorsData)
                    ]
                ]
            ]
        ];

        $this->doReadRelatedResources($model, 'category')
            ->assertRelatedResourceResponse($data);
    }

    public function testUpdateCategory()
    {
        $model = $this->model();

        /** @var Category $category */
        $category = factory(Category::class)->create();

        $this->doUpdateRelateResource($model, 'category', 'categories', $category->getKey());
        $this->assertModelPatched($model, ['category'=>$category]);
    }

    /**
     * Test the read contributors route.
     */
    public function testReadContributors()
    {
        $model = $this->model();

        $this->doReadRelatedResources($model, 'contributors')
            ->assertRelatedResourcesResponse(['contributors']);
    }

    /**
     * Test the read contributors route.
     */
    public function testAddContributors()
    {
        $model = $this->model();

        $relatedModels = $model->contributors->all();
        $relatedModelsToAdd = factory(Contributor::class, 3)->create()->all();

        $relatedIds = [];
        /** @var Model $relatedModel */
        foreach ($relatedModelsToAdd as $relatedModel) {
            $relatedIds[] = $relatedModel->getKey();
        }

        $response = $this->doAddRelatedResources($model, 'contributors', 'contributors', $relatedIds);

        $relationships = [];
        /** @var Model $relatedModel */
        foreach (array_merge($relatedModels, $relatedModelsToAdd) as $relatedModel) {
            $relationships[] = ['type' => 'contributors', 'id' => (string) $relatedModel->getKey()];
        }
        $response->assertRelatedResourcesResponse(['contributors'])->assertExactJson([
            'data' => $relationships
        ]);
    }

    /**
     * Test the read contributors route.
     */
    public function testRemoveContributors()
    {
        $model = $this->model();

        $relatedModels = $model->contributors->all();
        $relatedModelToRemove = array_pop($relatedModels);
        $response = $this->doRemoveRelatedResources($model, 'contributors', 'contributors', [$relatedModelToRemove->getKey()]);

        $relationships = [];
        /** @var Model $relatedModel */
        foreach ($relatedModels as $relatedModel) {
            $relationships[] = ['type' => 'contributors', 'id' => (string) $relatedModel->getKey()];
        }
        $response->assertRelatedResourcesResponse(['contributors'])->assertExactJson([
            'data' => $relationships
        ]);
    }

    /**
     * Test the read contributors route.
     */
    public function testReplaceContributors()
    {
        $model = $this->model();

        $relatedModelsToReplaceWith = (array) factory(Contributor::class, 3)->create()->all();

        $relatedIds = [];
        foreach ($relatedModelsToReplaceWith as $relatedModel) {
            $relatedIds[] = $relatedModel->getKey();
        }

        $response = $this->doReplaceRelatedResources($model, 'contributors', 'contributors', $relatedIds);

        $relationships = [];
        foreach ($relatedModelsToReplaceWith as $relatedModel) {
            $relationships[] = ['type' => 'contributors', 'id' => (string) $relatedModel->getKey()];
        }
        $response->assertRelatedResourcesResponse(['contributors'])->assertExactJson([
            'data' => $relationships
        ]);
    }

    /**
     * This is just a helper so that we get a type hinted model back.
     *
     * @param bool $create
     * @return Meditation
     */
    protected function model($create = true)
    {
        $builder = factory(Meditation::class);

        if($create) {
            /** @var Meditation $meditation */
            $meditation = $builder->create();
            $meditation->category()->associate(factory(Category::class)->create())->save();
            $meditation->contributors()->saveMany(factory(Contributor::class, 2)->create());
            return $meditation;
        } else {
            return $builder->make();
        }
    }
}