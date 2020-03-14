<?php


class GenerateDoctrine
{
    public function Generate(string $table, array $colum)
    {
        echo "<?php <p>";
        $this->Space(1);

        echo 'namespace Entity\MySQL; <p>';
        echo 'use Doctrine\ORM\Mapping as ORM;<p>';

        echo '/**<br>';
        echo '* @ORM\Entity<br>';
        echo "* @ORM\Table(name=\"$table\")<br>";
        echo '*/<br>';

        echo "class $table <br>";
        echo '{';

        foreach ($colum as $value) {
            if($value->Field == 'id')
            {
                echo '/**<br>';
                echo '* @ORM\Id <br>';
                echo '* @ORM\Column(type="integer") <br>';
                echo '* @ORM\GeneratedValue <br>';
                echo '* @var id <br>';
                echo '*/ <br>';
                echo "protected \$$value->Field; <br>";
            }else
            {
                $type = $this->Type($value->Type);
                echo '/** <br>';
                echo "*@ORM\Column(type=\"$type\") <br>";
                echo "*@var $type <br>";
                echo '*/ <br>';
                echo "protected \$$value->Field; <br>";
            }

            $this->Space(1);
        }

        foreach ($colum as $value) {
            $this->GetAndSet($value->Field);
        }

        echo '} <br>';
    }


    private function GetAndSet(string $name)
    {
        $value =  ucwords(str_replace('_' , ' ', $name));

        echo 'public function get'. str_replace(' ', '', $value)."()".'<br>';
        echo '{'.'<br>';
            echo "return \$this->$name; <br>";
        echo '}'.'<br>';
        echo 'public function set'.str_replace(' ', '', $value)."(\$$name)".'<br>';
        echo '{'.'<br>';
            echo "\$this->$name = \$$name; <br>";
        echo '}'.'<br>';
        $this->Space(1);
    }

    private function Space(int $count)
    {
        for ($i=0; $i < $count; $i++) 
            echo '<br>';
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