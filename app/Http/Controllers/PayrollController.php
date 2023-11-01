<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PayrollController extends Controller
{
    public function updatePayroll($payroll)
    {
        $payments = DB::table('payments')
            ->selectRaw('SUM(earnings) as earnings, SUM(deductions) as deductions, SUM(net_pay) as net_pay')
            ->where('payroll_id', $payroll->id)
            ->first();

        $data = [];
        if ($payroll->calculate_earnings == 'yes') {
            $data['earnings'] = $payments->earnings ? $payments->earnings : '0.00';
        }
        if ($payroll->calculate_deductions == 'yes') {
            $data['deductions'] = $payments->deductions ? $payments->deductions : '0.00';
        }
        if ($payroll->calculate_net_pay == 'yes') {
            $data['net_pay'] = $payments->net_pay ? $payments->net_pay : '0.00';
        }

        return $payroll->update($data);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payrolls = Payroll::all();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        $competencies = Category::where('slug', 'competencias')->with('children')->first();
        $typeLeafs = Category::where('slug', 'tipo-de-folha')->with('children')->first();
        return view('panel.payroll.index', compact('payrolls', 'exercicies', 'competencies', 'typeLeafs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        $competencies = Category::where('slug', 'competencias')->with('children')->first();
        $typeLeafs = Category::where('slug', 'tipo-de-folha')->with('children')->first();
        return view('panel.payroll.create', compact('exercicies', 'competencies', 'typeLeafs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'exercicy_id' => 'required',
            'competency_id' => 'required',
            'type_leaf_id' => 'required',
            'earnings' => $request->calculate_earnings == 'yes' ? 'nullable' : 'required',
            'calculate_earnings' => 'nullable',
            'deductions' => $request->calculate_deductions == 'yes' ? 'nullable' :  'required',
            'calculate_deductions' => 'nullable',
            'net_pay' => $request->calculate_net_pay == 'yes' ? 'nullable' :  'required',
            'calculate_net_pay' => 'nullable',
        ], [
            'employee_id.required' => 'O campo funcionário é obrigatório!',
            'exercicy_id.required' => 'O campo exercício é obrigatório!',
            'competency_id.required' => 'O campo competencia é obrigatório!',
            'type_leaf_id.required' => 'O campo Tipo de folha é obrigatório!',
            'net_pay.required' => 'O campo salário líquido é obrigatório!',
        ]);
        $validateData['earnings']   = $request->calculate_earnings      == 'yes' ? ($request->earnings ? str_replace(['R$', '.', ','], ['', '', '.'], $request->earnings) : '0.00') : null;
        $validateData['deductions'] = $request->calculate_deductions    == 'yes' ? ($request->deductions ? str_replace(['R$', '.', ','], ['', '', '.'], $request->deductions) : '0.00') : null;
        $validateData['net_pay']    = $request->calculate_net_pay       == 'yes' ? ($request->net_pay ? str_replace(['R$', '.', ','], ['', '', '.'], $request->net_pay) : '0.00') : null;

        $competency = Category::where('id', $request->competency_id)->first();
        $exercicy = Category::where('id', $request->exercicy_id)->first();
        $validateData['slug'] = Str::slug('payroll-' . $competency->name . '-' . $exercicy->name);
        
        $payroll = Payroll::create($validateData);

        if ($payroll) {
            return redirect()->route('payrolls.index')->with('success', 'Folha de pagamento cadastrada com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        return view('panel.payroll.payments.index', compact('payroll'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        $competencies = Category::where('slug', 'competencias')->with('children')->first();
        $typeLeafs = Category::where('slug', 'tipo-de-folha')->with('children')->first();
        $employees = Employee::all();
        return view('panel.payroll.edit', compact('payroll', 'exercicies', 'competencies', 'employees', 'typeLeafs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        $validateData = $request->validate([
            'exercicy_id' => 'required',
            'competency_id' => 'required',
            'type_leaf_id' => 'required',
            'earnings' => $request->calculate_earnings == 'yes' ? 'nullable' : 'required',
            'calculate_earnings' => 'nullable',
            'deductions' => $request->calculate_deductions == 'yes' ? 'nullable' :  'required',
            'calculate_deductions' => 'nullable',
            'net_pay' => $request->calculate_net_pay == 'yes' ? 'nullable' :  'required',
            'calculate_net_pay' => 'nullable',
        ], [
            'employee_id.required' => 'O campo funcionário é obrigatório!',
            'exercicy_id.required' => 'O campo exercício é obrigatório!',
            'competency_id.required' => 'O campo competencia é obrigatório!',
            'type_leaf_id.required' => 'O campo Tipo de folha é obrigatório!',
            'net_pay.required' => 'O campo salário líquido é obrigatório!',
        ]);
        $validateData['earnings']   = $request->calculate_earnings      == 'yes' ? ($request->earnings ? str_replace(['R$', '.', ','], ['', '', '.'], $request->earnings) : '0.00') : null;
        $validateData['deductions'] = $request->calculate_deductions    == 'yes' ? ($request->deductions ? str_replace(['R$', '.', ','], ['', '', '.'], $request->deductions) : '0.00') : null;
        $validateData['net_pay']    = $request->calculate_net_pay       == 'yes' ? ($request->net_pay ? str_replace(['R$', '.', ','], ['', '', '.'], $request->net_pay) : '0.00') : null;

        if ($payroll->update($validateData)) {
            if($request->calculate_earnings == 'yes'){
                $this->updatePayroll($payroll);
            }
            return redirect()->route('payrolls.index')->with('success', 'Folha de pagamento atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        if ($payroll->delete()) {
            return redirect()->route('payrolls.index')->with('success', 'Folha de pagamento deletado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    public function export()
    {
        $columns = [
            'id',
            'employee_id',
            'exercicy_id',
            'competency_id',
            'type_leaf_id',
            'base_salary',
            'earnings',
            'deductions',
            'net_pay',
            'hours_worked',
        ];

        $columnsForeign = [
            'employee:id,name',
            'exercicy:id,name',
            'competency:id,name',
            'typeLeaf:id,name',
        ];

        $data = Payroll::select($columns)->with($columnsForeign)->get();

        $columns[] = 'employee_name';
        $columns[] = 'exercicy_name';
        $columns[] = 'competency_name';
        $columns[] = 'typeLeaf_name';

        $csvFileName = 'payroll.csv';

        ini_set('auto_detect_line_endings', true);
        $delimiter = ';';

        $csvFile = fopen($csvFileName, 'w');
        stream_filter_append($csvFile, 'convert.iconv.utf-8/cp1252', STREAM_FILTER_WRITE);

        $columnsOrder = [
            'employee_id',
            'employee_name',
            'exercicy_id',
            'exercicy_name',
            'competency_id',
            'competency_name',
            'type_leaf_id',
            'typeLeaf_name',
            'base_salary',
            'earnings',
            'deductions',
            'net_pay',
            'hours_worked',
        ];

        fputcsv($csvFile, $columnsOrder, $delimiter);

        foreach ($data as $payroll) {
            // Mapeie os dados para as colunas
            $rowData = [
                $payroll->employee_id,
                $payroll->employee->name,
                $payroll->exercicy_id,
                $payroll->exercicy->name,
                $payroll->competency_id,
                $payroll->competency->name,
                $payroll->type_leaf_id,
                $payroll->typeLeaf->name,
                $payroll->base_salary,
                $payroll->earnings,
                $payroll->deductions,
                $payroll->net_pay,
                $payroll->hours_worked,
            ];

            fputcsv($csvFile, $rowData, $delimiter);
        }

        fclose($csvFile);

        return response()->download($csvFileName)->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');

            // Verifique se o arquivo é um CSV válido
            if ($file->getClientOriginalExtension() === 'csv') {
                $path = $file->getRealPath();

                // Abra o arquivo CSV
                $handle = fopen($path, 'r');

                $index = 0;
                while (($line = fgetcsv($handle, 0, ";")) !== false) {
                    // dd($line);
                    if ($index != 0) {
                        $employee_name = iconv(mb_detect_encoding($line['1'], mb_detect_order(), true), 'UTF-8', $line['1']);

                        Payroll::create([
                            'employee_id' => $line['0'],
                            // 'employee_name' => $line['1'],
                            'exercicy_id' => $line['2'],
                            // 'exercicy_name' => $line['3'],
                            'competency_id' => $line['4'],
                            // 'competency_name' => $line['5'],
                            'type_leaf_id' => $line['6'],
                            // 'typeLeaf_name' => $line['7'],
                            'base_salary' => (float)$line['8'],
                            'earnings' => (float)$line['9'],
                            'deductions' => (float)$line['10'],
                            'net_pay' => (float)$line['11'],
                            'hours_worked' => $line['12'],
                            'slug' => Str::slug('payroll-' . $employee_name . '-' . $line['4']),
                        ]);
                    }
                    $index++;
                }

                fclose($handle);

                return redirect()->back()->with('success', 'Folha de pagamento importada com sucesso.');
            } else {
                return redirect()->back()->with('error', 'O arquivo não é um CSV válido.');
            }
        }

        return redirect()->back()->with('error', 'Nenhum arquivo CSV enviado.');
    }
}
