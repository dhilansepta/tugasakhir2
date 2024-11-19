<?php

namespace App\Notifications;

use App\Models\Barang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BatchStokNotification extends Notification
{
    use Queueable;

    public $stok;
    public $idBarang;
    public $satuan;
    /**
     * Create a new notification instance.
     */
    public function __construct($idBarang, $stok, $satuan)
    {
        $this->idBarang = $idBarang;
        $this->stok = $stok;
        $this->satuan = $satuan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $barang = Barang::find($this->idBarang);
        return (new MailMessage)
        ->subject('Peringatan Stok Barang Menipis!')
        ->line('Stok barang ' . $barang->nama_barang . ' Tersisa ' . $this->stok . ' ' . $this->satuan);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $barang = Barang::find($this->idBarang);
        return [
            'data' => $barang->nama_barang . ' Tersisa ' . $this->stok .' ' . $this->satuan,
            'id_barang' => $this->idBarang,
        ];
    }
}
