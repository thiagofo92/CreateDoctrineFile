<?php

class CreateFileDoctrine
{
    public function Create(string $table, array $colum)
    {
        $file = fopen("./SQL/$table".".php", 'w');
        fwrite($file,"<?php \n");
        $this->Space(1 , $file);

        fwrite($file,"namespace Entity\MySQL; \n");
        fwrite($file,"use Doctrine\ORM\Mapping as ORM;\n");

        fwrite($file,"/**\n");
        fwrite($file,"* @ORM\Entity\n");
        fwrite($file,"* @ORM\Table(name=\"$table\")\n");
        fwrite($file,"*/\n");

        fwrite($file,"class $table \n");
        fwrite($file,'{');

        foreach ($colum as $value) {
            if($value->Field == 'id')
            {
                fwrite($file,"/**\n");
                fwrite($file,"* @ORM\Id \n");
                fwrite($file,"* @ORM\Column(type=\"integer\") \n");
                fwrite($file,"* @ORM\GeneratedValue \n");
                fwrite($file,"* @var id \n");
                fwrite($file,"*/ \n");
                fwrite($file,"protected \$$value->Field;" . "\n");
            }else
            {
                $type = $this->Type($value->Type, $file);

                fwrite($file,'/** \n');
                fwrite($file,"*@ORM\Column(type=\"$type\") \n" . "\n");
                fwrite($file,"*@var $type \n");
                fwrite($file,"*/ \n");
                fwrite($file,"protected \$$value->Field; \n");
            }

            $this->Space(1 , $file);
        }

        foreach ($colum as $value) {
            $this->GetAndSet($value->Field, $file);
        }

        fwrite($file,"} \n");

        fclose($file);
    }


    private function GetAndSet(string $name, $file)
    {
        $value =  ucwords(str_replace('_' , ' ', $name));

        fwrite($file,"public function get". str_replace(' ', '', $value)."()"."\n");
        fwrite($file,"{"."\n");
            fwrite($file,"return \$this->$name; \n");
        fwrite($file,"}"."\n");
        fwrite($file,"public function set".str_replace(' ', '', $value)."(\$$name)"."\n");
        fwrite($file,"{"."\n");
            fwrite($file,"\$this->$name = \$$name; \n");
            fwrite($file,"}"."\n");

        $this->Space(1, $file);
    }

    private function Space(int $count, $file)
    {
        for ($i=0; $i < $count; $i++) 
            fwrite($file,"\n");
    }

    private function Type($data_type)
    {
        $type = strval($data_type);

        if(strpos($type, 'var')  !== false or strpos($type, 'char') !== false or $type == 'text')
            return 'string';

        if (strpos($type, 'tinyint') !== false)
            return 'integer';

        if(strpos($type,"int") !== false)
            return 'integer';
        
        if(strpos($type, 'datetime') !== false)
            return 'string';

        if (strpos($type, 'date') !== false)
            return 'string';

        if (strpos($type, 'time') !== false)
            return 'string';

        if (strpos($type, 'enum') !== false)
            return 'string';

        return '';
    }
}