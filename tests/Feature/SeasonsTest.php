<?php

namespace Tests\Feature;


use App\Contributor;
use App\Podcast;
use App\Season;

class SeasonsTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $resourceType = 'seasons';

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
        $models = factory(Season::class, 2)->create();
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

        /** @var Podcast $podcast */
        $podcast = factory(Podcast::class)->create();

        $data = [
            'type' => 'seasons',
            'attributes' => [
                'title' => $model->title,
                'description' => $model->description,
                'image-url' => $model->image_url,
                'number' => $model->number
            ]
        ];

        $id = $this
            ->doCreate($data)
            ->assertCreateResponse($data);

        $this->assertModelCreated($model, $id, ['title', 'description', 'image_url', 'number']);
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
            'type' => 'seasons',
            'id' => $model->getKey(),
            'attributes' => [
                'created-at' => $model->created_at->getTimestamp(),
                'updated-at' => $model->updated_at->getTimestamp(),
                'title' => $model->title,
                'description' => $model->description,
                'image-url' => $model->image_url,
                'number' => $model->number
            ],
            'relationships' => [
                'podcast' => [
                    'data' => [
                        'type' => 'podcasts',
                        'id' => $model->podcast->getKey(),
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
            'type' => 'seasons',
            'id' => (string) $model->getKey(),
            'attributes' => [
                'title' => 'Foo',
            ],
        ];

        $responseDate = $this->doUpdate($data)->assertUpdateResponse($data)->getDate();
        $this->assertModelPatched($model, [
            'title' => 'Foo',
            'updated_at' => $responseDate
        ], ['created_at', 'description', 'image_url', 'number']);
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
     * Test the read contributors route.
     */
    public function testReadPodcast()
    {
        $model = $this->model();

        $podcast = $model->podcast;

        $contributorsData = [];
        foreach ($podcast->contributors as $contributor) {
            $contributorsData[] = [
                'type' => 'contributors',
                'id' => $contributor->getKey()
            ];
        }

        $seasonsData = [];
        foreach ($podcast->seasons as $season) {
            $seasonsData[] = [
                'type' => 'seasons',
                'id' => $season->getKey()
            ];
        }

        $data = [
            'type' => 'podcasts',
            'id' => $podcast->getKey(),
            'attributes' => [
                'created-at' => $podcast->created_at->getTimestamp(),
                'updated-at' => $podcast->updated_at->getTimestamp(),
                'title' => $podcast->title,
                'description' => $podcast->description,
                'image-url' => $podcast->image_url
            ],
            'relationships' => [
                'seasons' => [
                    'data' => $seasonsData,
                    'meta' => [
                        'total' => count($seasonsData)
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

        $this->doReadRelatedResources($model, 'podcast')
            ->assertRelatedResourceResponse($data);
    }

    public function testUpdatePodcast()
    {
        $model = $this->model();

        /** @var Podcast $podcast */
        $podcast = factory(Podcast::class)->create();

        $this->doUpdateRelateResource($model, 'podcast', 'podcasts', $podcast->getKey());
        $this->assertModelPatched($model, ['podcast'=>$podcast]);
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
        foreach ($relatedModelsToAdd as $relatedModel) {
            $relatedIds[] = $relatedModel->getKey();
        }

        $response = $this->doAddRelatedResources($model, 'contributors', 'contributors', $relatedIds);

        $relationships = [];
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
     * @return Season
     */
    protected function model($create = true)
    {
        $builder = factory(Season::class);

        if($create) {
            /** @var Season $season */
            $season = $builder->create();
            $season->podcast()->associate(factory(Podcast::class)->create())->save();
            $season->contributors()->saveMany(factory(Contributor::class, 2)->create());
            return $season;
        } else {
            return $builder->make();
        }
    }
}