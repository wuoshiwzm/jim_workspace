package testjava;

public class SingleStack<AnyType> {

		SingleStack(){
			head = null;
		}
		
		void push(AnyType x){
			Node<AnyType> p = new Node<AnyType>(x,head);
			head = p;
		}
		
		AnyType top(){
			return head.data;
		}
		
		void pop(){
			head = head.next;
		}
		
		
		
		private class Node<AnyType>{
			
			Node(){
				this(null,null);
			}
			Node(AnyType x){
				this(x,null);
			}
			Node(AnyType x,Node p){
				data = x;
				next = p;
			}
			AnyType data;
			Node next;
		}
		
		private Node<AnyType> head;
		


	
}
