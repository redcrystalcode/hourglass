<?php

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use Hourglass\Http\Requests\RoundingRules\CreateRoundingRuleRequest;
use Hourglass\Models\RoundingRule;
use Hourglass\Transformers\RoundingRuleTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;

class RoundingRuleController extends BaseController
{
    /**
     * RoundingRuleController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \League\Fractal\Manager $fractal
     * @param \Hourglass\Transformers\RoundingRuleTransformer $transformer
     */
    public function __construct(Guard $guard, FractalManager $fractal, RoundingRuleTransformer $transformer)
    {
        parent::__construct($guard, $fractal);
        $this->transformer = $transformer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $rules = $this->account->roundingRules()->orderBy('start')->get();
        return $this->respondWithCollection($rules);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\RoundingRules\CreateRoundingRuleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRoundingRuleRequest $request)
    {
        $rule = new RoundingRule();
        $rule->criteria = $request->get('criteria');
        $rule->start = $this->parseTimeString($request->get('start'));
        $rule->end = $this->parseTimeString($request->get('end'));
        $rule->resolution = $this->parseTimeString($request->get('resolution'));
        
        $this->account->roundingRules()->save($rule);
        
        return $this->respondWithItem($rule);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $rule = $this->account->roundingRules()->whereId($id)->first();
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
    public function update(Request $request, $id)
    {
        /** @var RoundingRule $rule */
        $rule = $this->account->roundingRules()->find($id);
        
        if (!$rule) {
            throw new ModelNotFoundException();
        }

        $rule->criteria = $request->get('criteria');
        $rule->start = $this->parseTimeString($request->get('start'));
        $rule->end = $this->parseTimeString($request->get('end'));
        $rule->resolution = $this->parseTimeString($request->get('resolution'));
        
        $this->account->roundingRules()->save($rule);
        
        return $this->respondWithItem($rule);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        /** @var RoundingRule $rule */
        $rule = $this->account->roundingRules()->find($id);
        
        if (!$rule) {
            throw new ModelNotFoundException();
        }
        
        $rule->delete();
    }

    private function parseTimeString($time)
    {
        return Carbon::createFromFormat('g:i a', $time, $this->account->timezone)->toTimeString();
    }
}
