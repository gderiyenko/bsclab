<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Firm;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FirmRepository extends BaseRepository
{
    public $sortBy = 'firm_name';
    public $sortOrder = 'asc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Firm $model Repo DB ORM Model
     */
    public function __construct(Firm $model, File $file)
    {
        $this->model = $model;
        $this->file = $file;
    }

    /**
     * Get all instances of model.
     *
     * @return Collection
     */
    public function allWithTrashed(): Collection
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->withTrashed()->get();
    }

    /**
     * Update record in the database and get data back.
     *
     * @param string $id
     * @param array  $data
     *
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        $query = $this->model->withTrashed()->where('id', $id);
        return $query->update($data);
    }

    public function all(): Collection
    {
        $firms = $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        foreach ($firms as $firmKey => $firm) {
            $firms[$firmKey]['isContract'] = $firm->contracts->count() ? true : null;
            $firms[$firmKey]['isInvoice'] = $firm->invoices->count() ? true : null;
        }

        return $firms;
    }

    public function noActs()
    {
        $firmsPartOne = DB::table('firms as f')
            ->select(DB::raw("
                f.id as firmId,
                f.firm_name_short as firmNameShort,
                c.number as contractNumber,
                i.number as invoiceNumber,
                i.amount as invoiceAmount,
                p.amount as paymentAmount,
                a.number as actNumber,
                (SELECT title FROM files WHERE files.title = 'vytyah' and files.firm_id = f.id LIMIT 1) as isVytyahFile,
                (SELECT title FROM files WHERE files.title = 'statut' and files.firm_id = f.id LIMIT 1) as isStatutFile,
                (SELECT title FROM files WHERE files.title = 'vypyska' and files.firm_id = f.id LIMIT 1) as isVypyskaFile,
                (SELECT title FROM files WHERE files.title = 'nds' and files.firm_id = f.id LIMIT 1) as isNdsFile,
                (SELECT title FROM files WHERE files.title = 'nakaz' and files.firm_id = f.id LIMIT 1) as isNakazFile,
                (SELECT title FROM files WHERE files.title = 'protocol' and files.firm_id = f.id LIMIT 1) as isProtocolFile
                "))
            ->leftJoin('contracts as c', 'c.firm_id', '=', 'f.id')
            ->leftJoin('invoices as i', 'c.id', '=', 'i.contract_id')
            ->leftJoin('payments as p', 'i.id', '=', 'p.invoice_id')
            ->leftJoin('acts as a', 'i.id', '=', 'a.invoice_id')
            ->whereNull('a.number')
            ->get();

        $firmsPartTwo = DB::table('firms as f')
            ->select(DB::raw("
                f.id as firmId,
                f.firm_name_short as firmNameShort,
                i.contract_id as contractNumber,
                i.number as invoiceNumber,
                i.amount as invoiceAmount,
                p.amount as paymentAmount,
                a.number as actNumber,
                (SELECT title FROM files WHERE files.title = 'vytyah' and files.firm_id = f.id LIMIT 1) as isVytyahFile,
                (SELECT title FROM files WHERE files.title = 'statut' and files.firm_id = f.id LIMIT 1) as isStatutFile,
                (SELECT title FROM files WHERE files.title = 'vypyska' and files.firm_id = f.id LIMIT 1) as isVypyskaFile,
                (SELECT title FROM files WHERE files.title = 'nds' and files.firm_id = f.id LIMIT 1) as isNdsFile,
                (SELECT title FROM files WHERE files.title = 'nakaz' and files.firm_id = f.id LIMIT 1) as isNakazFile,
                (SELECT title FROM files WHERE files.title = 'protocol' and files.firm_id = f.id LIMIT 1) as isProtocolFile
                "))
            ->leftJoin('invoices as i', function ($join) {
                $join->on('f.id', '=', 'i.firm_id')->whereNull('i.contract_id');
            })
            ->leftJoin('payments as p', 'i.id', '=', 'p.invoice_id')
            ->leftJoin('acts as a', 'i.id', '=', 'a.invoice_id')
            ->whereNull('a.number')
            ->whereNotNull('i.id')
            ->get();

        return $firmsPartOne->merge($firmsPartTwo)->sortBy(['firmNameShort', 'asc']);
    }
}
