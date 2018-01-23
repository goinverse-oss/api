<?php

namespace Tests\Feature;


use App\Contributor;
use App\Podcast;

class ContributorsTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $resourceType = 'contributors';

    /**
     * Test the search route.
     */
    public function testSearch()
    {
        // ensure there is at least one contributor in the database
        $this->model();

        $this->doSearch()
            ->assertSearchResponse();
    }

    /**
     * Test searching for specific ids
     */
    public function testSearchById()
    {
        $models = factory(Contributor::class, 2)->create();
        // This contributor should not be returned in the results
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
            'type' => 'contributors',
            'attributes' => [
                'name' => $model->name,
                'bio' => $model->bio,
                'image-url' => $model->image_url,
                'url' => $model->url,
                'twitter' => $model->twitter,
                'facebook' => $model->facebook,
            ],
        ];

        $id = $this
            ->doCreate($data)
            ->assertCreateResponse($data);

        $this->assertModelCreated($model, $id, ['name', 'bio', 'image_url', 'url', 'twitter', 'facebook']);
    }

    /**
     * Test the read resource route.
     */
    public function testRead()
    {
        $model = $this->model();

        $podcastsData = [];
        foreach ($model->podcasts as $podcast) {
            $podcastsData[] = [
                'type' => 'podcasts',
                'id' => $podcast->getKey()
            ];
        }

        $data = [
            'type' => 'contributors',
            'id' => $model->getKey(),
            'attributes' => [
                'name' => $model->name,
                'bio' => $model->bio,
                'image-url' => $model->image_url,
                'url' => $model->url,
                'twitter' => $model->twitter,
                'facebook' => $model->facebook,
            ],
            'relationships' => [
                'podcasts' => [
                    'data' => $podcastsData,
                    'meta' => [
                        'total' => count($podcastsData)
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
            'type' => 'contributors',
            'id' => (string) $model->getKey(),
            'attributes' => [
                'name' => 'Foo',
            ],
        ];

        $responseDate = $this->doUpdate($data)->assertUpdateResponse($data)->getDate();
        $this->assertModelPatched($model, [
            'name' => 'Foo',
            'updated_at' => $responseDate
        ], ['bio', 'image_url', 'url', 'twitter', 'facebook']);
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
     * Test the read podcasts route.
     */
    public function testReadPodcasts()
    {
        $model = $this->model();

        $this->doReadRelatedResources($model, 'podcasts')
            ->assertRelatedResourcesResponse(['podcasts']);
    }

    /**
     * Test the read podcasts route.
     */
    public function testAddPodcasts()
    {
        $model = $this->model();

        $relatedModels = $model->podcasts->all();
        $relatedModelsToAdd = factory(Podcast::class, 3)->create()->all();

        $relatedIds = [];
        foreach ($relatedModelsToAdd as $relatedModel) {
            $relatedIds[] = $relatedModel->getKey();
        }

        $response = $this->doAddRelatedResources($model, 'podcasts', 'podcasts', $relatedIds);

        $relationships = [];
        foreach (array_merge($relatedModels, $relatedModelsToAdd) as $relatedModel) {
            $relationships[] = ['type' => 'podcasts', 'id' => (string) $relatedModel->getKey()];
        }
        $response->assertRelatedResourcesResponse(['podcasts'])->assertExactJson([
            'data' => $relationships
        ]);
    }

    /**
     * Test the read podcasts route.
     */
    public function testRemovePodcasts()
    {
        $model = $this->model();

        $relatedModels = $model->podcasts->all();
        $relatedModelToRemove = array_pop($relatedModels);
        $response = $this->doRemoveRelatedResources($model, 'podcasts', 'podcasts', [$relatedModelToRemove->getKey()]);

        $relationships = [];
        foreach ($relatedModels as $relatedModel) {
            $relationships[] = ['type' => 'podcasts', 'id' => (string) $relatedModel->getKey()];
        }
        $response->assertRelatedResourcesResponse(['podcasts'])->assertExactJson([
            'data' => $relationships
        ]);
    }

    /**
     * Test the read podcasts route.
     */
    public function testReplacePodcasts()
    {
        $model = $this->model();

        $relatedModelsToReplaceWith = (array) factory(Podcast::class, 3)->create()->all();

        $relatedIds = [];
        foreach ($relatedModelsToReplaceWith as $relatedModel) {
            $relatedIds[] = $relatedModel->getKey();
        }

        $response = $this->doReplaceRelatedResources($model, 'podcasts', 'podcasts', $relatedIds);

        $relationships = [];
        foreach ($relatedModelsToReplaceWith as $relatedModel) {
            $relationships[] = ['type' => 'podcasts', 'id' => (string) $relatedModel->getKey()];
        }
        $response->assertRelatedResourcesResponse(['podcasts'])->assertExactJson([
            'data' => $relationships
        ]);
    }

    /**
     * This is just a helper so that we get a type hinted model back.
     *
     * @param bool $create
     * @return Contributor
     */
    protected function model($create = true)
    {
        $builder = factory(Contributor::class);

        if($create) {
            $contributor = $builder->create();
            $contributor->podcasts()->saveMany(factory(Podcast::class, 2)->create());
            return $contributor;
        } else {
            return $builder->make();
        }
    }
}