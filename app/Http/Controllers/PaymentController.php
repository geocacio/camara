<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
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
    public function index(Payroll $payroll)
    {
        return view('panel.payroll.payments.index', compact('payroll'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Payroll $payroll)
    {
        $employees = Employee::all();
        return view('panel.payroll.payments.create', compact('payroll', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Payroll $payroll, Request $request)
    {
        $validateData = $request->validate([
            'employee_id' => 'required',
            'earnings' => 'nullable',
            'deductions' => 'nullable',
            'net_pay' => 'required',
        ], [
            'employee_id.required' => 'O campo funcionário é obrigatório!',
            'net_pay.required' => 'O campo salário líquido é obrigatório!',
        ]);
        $validateData['earnings'] = $request->earnings ? str_replace(['R$', '.', ','], ['', '', '.'], $request->earnings) : '0.00';
        $validateData['deductions'] = $request->deductions ? str_replace(['R$', '.', ','], ['', '', '.'], $request->deductions) : '0.00';
        $validateData['net_pay'] = str_replace(['R$', '.', ','], ['', '', '.'], $request->net_pay);
        $validateData['payroll_id'] = $payroll->id;
        $nextId = Payment::max('id') + 1;

        $validateData['slug'] = Str::slug('payment' . $payroll->competency->name . '-' . $payroll->exercicy->name . '-' . $nextId);

        $payment = Payment::create($validateData);

        if ($payment) {
            $this->updatePayroll($payroll);
            return redirect()->route('payments.index', $payroll->slug)->with('success', 'Pagamento cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll, Payment $payment)
    {
        // dd($payment);
        $employees = Employee::all();
        return view('panel.payroll.payments.edit', compact('payment', 'payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Payroll $payroll, Request $request, Payment $payment)
    {
        $validateData = $request->validate([
            'employee_id' => 'required',
            'earnings' => 'nullable',
            'deductions' => 'nullable',
            'net_pay' => 'required',
        ], [
            'employee_id.required' => 'O campo funcionário é obrigatório!',
            'net_pay.required' => 'O campo salário líquido é obrigatório!',
        ]);
        $validateData['earnings'] = $request->earnings ? str_replace(['R$', '.', ','], ['', '', '.'], $request->earnings) : '0.00';
        $validateData['deductions'] = $request->deductions ? str_replace(['R$', '.', ','], ['', '', '.'], $request->deductions) : '0.00';
        $validateData['net_pay'] = str_replace(['R$', '.', ','], ['', '', '.'], $request->net_pay);
        $validateData['payroll_id'] = $payroll->id;

        if ($payment->update($validateData)) {
            $this->updatePayroll($payroll);
            return redirect()->route('payments.index', $payroll->slug)->with('success', 'Pagamento cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll, Payment $payment)
    {

        if ($payment->delete()) {
            $this->updatePayroll($payroll);
            return redirect()->route('payments.index', $payroll->slug)->with('success', 'Pagamento excluído com sucesso!');
        }
        return redirect()->route('payments.index', $payroll->slug)->with('error', 'Por favor tente novamente!');
    }

    public function exportModel(){
        $employees = Employee::select('id', 'name')->get();
        // dd($employees);
        $nextPayrollId = Payroll::max('id') + 1;
        $csvFileName = 'payments-model.csv';

        ini_set('auto_detect_line_endings', true);
        $delimiter = ';';

        $csvFile = fopen($csvFileName, 'w');
        stream_filter_append($csvFile, 'convert.iconv.utf-8/cp1252', STREAM_FILTER_WRITE);

        $columnsOrder = [
            'payroll_id',
            'payroll_name',
            'employee_id',
            'employee_name',
            'earnings',
            'deductions',
            'net_pay',
        ];

        fputcsv($csvFile, $columnsOrder, $delimiter);
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $month = Carbon::now()->isoFormat('MMMM');
        foreach ($employees as $employee) {
            // Mapeie os dados para as colunas
            $rowData = [
                $nextPayrollId,
                ucfirst($month) . '/' . date('Y'),
                $employee->id,
                $employee->name,
            ];

            fputcsv($csvFile, $rowData, $delimiter);
        }

        fclose($csvFile);

        return response()->download($csvFileName)->deleteFileAfterSend(true);
    }

    public function export()
    {
        $columns = [
            'payroll_id',
            'employee_id',
            'earnings',
            'deductions',
            'net_pay',
        ];

        $columnsForeign = [
            'employee:id,name',
            'payroll',
        ];

        $data = Payment::select($columns)->with($columnsForeign)->get();
        $csvFileName = 'payments.csv';

        ini_set('auto_detect_line_endings', true);
        $delimiter = ';';

        $csvFile = fopen($csvFileName, 'w');
        stream_filter_append($csvFile, 'convert.iconv.utf-8/cp1252', STREAM_FILTER_WRITE);

        $columnsOrder = [
            'payroll_id',
            'payroll_name',
            'employee_id',
            'employee_name',
            'earnings',
            'deductions',
            'net_pay',
        ];

        fputcsv($csvFile, $columnsOrder, $delimiter);

        foreach ($data as $payment) {
            // Mapeie os dados para as colunas
            $rowData = [
                $payment->payroll_id,
                $payment->payroll->competency->name . '/' . $payment->payroll->exercicy->name,
                $payment->employee_id,
                $payment->employee->name,
                $payment->earnings,
                $payment->deductions,
                $payment->net_pay,
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

                $handle = fopen($path, 'r');

                $index = 0;
                while (($line = fgetcsv($handle, 0, ";")) !== false) {
                    if ($index != 0) {
                        $payroll_name = iconv(mb_detect_encoding($line['1'], mb_detect_order(), true), 'UTF-8', $line['1']);
                        $nextId = Payment::max('id') + 1;
                        Payment::create([
                            'payroll_id' => $line['0'],
                            'employee_id' => $line['2'],
                            'earnings' => (float)$line['4'],
                            'deductions' => (float)$line['5'],
                            'net_pay' => (float)$line['6'],
                            'slug' => Str::slug('payment-' . $payroll_name . '-' . $nextId),
                        ]);
                        $payroll = Payroll::find($line['0']);
                        $this->updatePayroll($payroll);
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
