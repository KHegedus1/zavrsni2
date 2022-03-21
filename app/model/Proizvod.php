<?php

class Proizvod
{
    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select * from proizvod where sifra=:parametar;
        
        ');
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetch();
    }
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, a.zanr, a.izvodac, a.naziv, a.cijena, a.izdavackaKuca, a.zaliha,
        count(b.sifra) as kosarica
        from proizvod a left join kosarica b
        on a.sifra=b.proizvod
        group by a.sifra, a.zanr, a.izvodac, a.naziv, a.cijena, a.izdavackaKuca, a.zaliha
        order by 3;
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        insert into proizvod (zanr,izvodac,naziv,cijena,izdavackaKuca,zaliha)
        values (:zanr,:izvodac,:naziv,:cijena,:izdavackaKuca,:zaliha);
        
        ');
        $izraz->execute($parametri);
    }
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        update proizvod set 
            zanr=:zanr,
            izvodac=:izvodac,
            naziv=:naziv,
            cijena=:cijena,
            izdavackaKuca=:izdavackaKuca,
            zaliha=:zaliha
            where sifra=:sifra;
        
        ');
        $izraz->execute($parametri);
    }
    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        delete from proizvod where sifra=:sifra;
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
    }
}