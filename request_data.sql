
CREATE TABLE `akses` (
  `id_akses` varchar(50) NOT NULL DEFAULT '',
  `kode_klien` varchar(20) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `akuntansi` varchar(50) DEFAULT NULL,
  `perpajakan` varchar(50) DEFAULT NULL,
  `lainnya` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `data_akuntansi` (
  `id_data` varchar(50) NOT NULL,
  `id_jenis` varchar(50) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `status_kirim` varchar(20) DEFAULT NULL,
  `status_proses` varchar(20) DEFAULT NULL,
  `reminder` varchar(20) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `data_lainnya` (
  `id_data` varchar(50) NOT NULL,
  `id_jenis` varchar(50) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `status_kirim` varchar(20) DEFAULT NULL,
  `status_proses` varchar(20) DEFAULT NULL,
  `reminder` varchar(20) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `data_perpajakan` (
  `id_data` varchar(50) NOT NULL,
  `id_jenis` varchar(50) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `status_kirim` varchar(20) DEFAULT NULL,
  `status_proses` varchar(20) DEFAULT NULL,
  `reminder` varchar(20) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `jenis_data` (
  `kode_jenis` varchar(20) NOT NULL DEFAULT '',
  `jenis_data` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1001, 1001, 'secretkey', 1, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `klien`
--

CREATE TABLE `klien` (
  `id_klien` varchar(20) NOT NULL DEFAULT '',
  `nama_klien` varchar(255) DEFAULT NULL,
  `nama_usaha` varchar(255) DEFAULT NULL,
  `kode_klu` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `email_klien` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `no_akte` varchar(255) DEFAULT NULL,
  `status_pekerjaan` varchar(255) DEFAULT NULL,
  `nama_pimpinan` varchar(255) DEFAULT NULL,
  `no_hp_pimpinan` varchar(255) DEFAULT NULL,
  `email_pimpinan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `nama_counterpart` varchar(255) DEFAULT NULL,
  `no_hp_counterpart` varchar(255) DEFAULT NULL,
  `email_counterpart` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `klu` (
  `kode_klu` varchar(20) NOT NULL,
  `bentuk_usaha` varchar(255) DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pengiriman_akuntansi` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_pengiriman` varchar(255) DEFAULT NULL,
  `kode_data` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pengiriman_lainnya` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_pengiriman` varchar(255) DEFAULT NULL,
  `kode_data` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_perpajakan`
--

CREATE TABLE `pengiriman_perpajakan` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_pengiriman` varchar(255) DEFAULT NULL,
  `kode_data` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_akuntansi`
--

CREATE TABLE `permintaan_akuntansi` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `bulan` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `jum_data` varchar(10) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `permintaan_lainnya` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `bulan` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `permintaan_perpajakan` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `bulan` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `proses_akuntansi` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(50) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `kode_data` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `proses_lainnya` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(50) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `kode_data` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proses_perpajakan`
--

CREATE TABLE `proses_perpajakan` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(50) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `kode_data` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `token` (
  `token` varchar(300) NOT NULL DEFAULT '',
  `id_user` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tugas` (
  `kode_tugas` varchar(50) NOT NULL DEFAULT '',
  `nama_tugas` varchar(255) DEFAULT NULL,
  `accounting_service` varchar(20) DEFAULT NULL,
  `review` varchar(20) DEFAULT NULL,
  `semi_review` varchar(20) DEFAULT NULL,
  `id_jenis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `passlength` varchar(10) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `confirmed` varchar(20) DEFAULT NULL,
  `apikey` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `passlength`, `level`, `nama`, `email_user`, `confirmed`, `apikey`) VALUES
('1001', 'admindata', '$2y$10$2H3HHQLUmmngXdgC7bcNoemxSICgA1imM0AYYVp7/hxW7QBNrw5Yu', '8', 'admin', 'Administrator', 'admindata@gmail.com', NULL, 'secretkey');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`id_bulan`);

--
-- Indexes for table `jenis_data`
--
ALTER TABLE `jenis_data`
  ADD PRIMARY KEY (`kode_jenis`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klien`
--
ALTER TABLE `klien`
  ADD PRIMARY KEY (`id_klien`);

--
-- Indexes for table `klu`
--
ALTER TABLE `klu`
  ADD PRIMARY KEY (`kode_klu`);

--
-- Indexes for table `pengiriman_akuntansi`
--
ALTER TABLE `pengiriman_akuntansi`
  ADD PRIMARY KEY (`id_pengiriman`);

--
-- Indexes for table `permintaan_akuntansi`
--
ALTER TABLE `permintaan_akuntansi`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indexes for table `proses_akuntansi`
--
ALTER TABLE `proses_akuntansi`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indexes for table `status_pekerjaan`
--
ALTER TABLE `status_pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`kode_tugas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;