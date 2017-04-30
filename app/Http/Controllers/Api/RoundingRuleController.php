<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Http\Requests\RoundingRules\CreateRoundingRuleRequest;
use Hourglass\Models\RoundingRule;
use Hourglass\Transformers\RoundingRuleTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;

class RoundingRuleController extends BaseController
{
	/**
	 * RoundingRuleController constructor.
	 *
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 * @param \Illuminate\Contracts\Auth\Guard $guard
	 * @param \League\Fractal\Manager $fractal
	 * @param \Hourglass\Transformers\RoundingRuleTransformer $transformer
	 */
	public function __construct(
		EntityManager $em,
		Guard $guard,
		FractalManager $fractal,
		RoundingRuleTransformer $transformer
	) {
		parent::__construct($em, $guard, $fractal);
		$this->transformer = $transformer;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        $rules = $this->resolveAccount($this->account)->roundingRules()->orderBy('start')->get();
        return $this->respondWithCollection($rules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\RoundingRules\CreateRoundingRuleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRoundingRuleRequest $request) : JsonResponse
    {
        $rule = new RoundingRule();
        $rule->criteria = $request->get('criteria');
        $rule->start = $this->parseTimeString($request->get('start'));
        $rule->end = $this->parseTimeString($request->get('end'));
        $rule->resolution = $this->parseTimeString($request->get('resolution'));

        $this->resolveAccount($this->account)->roundingRules()->save($rule);

        return $this->respondWithItem($rule);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $rule = $this->resolveAccount($this->account)->roundingRules()->whereId($id)->first();
        return $this->respondWithItem($rule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        /** @var RoundingRule $rule */
        $rule = $this->resolveAccount($this->account)->roundingRules()->find($id);

        if (!$rule) {
            throw new ModelNotFoundException();
        }

        $rule->criteria = $request->get('criteria');
        $rule->start = $this->parseTimeString($request->get('start'));
        $rule->end = $this->parseTimeString($request->get('end'));
        $rule->resolution = $this->parseTimeString($request->get('resolution'));

        $this->resolveAccount($this->account)->roundingRules()->save($rule);

        return $this->respondWithItem($rule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
	 *
	 * @return void
     */
    public function destroy(int $id) : void
    {
        /** @var RoundingRule $rule */
        $rule = $this->resolveAccount($this->account)->roundingRules()->find($id);

        if (!$rule) {
            throw new ModelNotFoundException();
        }

        $rule->delete();
    }

	/**
	 * @param string $time
	 *
	 * @return string
	 */
    private function parseTimeString(string $time) : string
    {
        return Carbon::createFromFormat('g:i a', $time, $this->resolveAccount($this->account)->timezone)->toTimeString();
    }
}
