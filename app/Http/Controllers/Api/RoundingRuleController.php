<?php

namespace Hourglass\Http\Controllers\Api;

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoundingRuleRequest $request)
    {
        $rule = new RoundingRule($request->only([
            'start',
            'end',
            'criteria',
            'resolution'
        ]));
        
        $this->account->roundingRules()->save($rule);
        
        return $this->respondWithItem($rule);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var RoundingRule $rule */
        $rule = $this->account->roundingRules()->find($id);
        
        if (!$rule) {
            throw new ModelNotFoundException();
        }
        
        $rule->fill($request->only([
            'start',
            'end',
            'criteria',
            'resolution'
        ]));
        
        $this->account->roundingRules()->save($rule);
        
        return $this->respondWithItem($rule);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
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
}
